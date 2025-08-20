<?php

namespace App\Http\Controllers;

use App\Models\DayOfWeek;
use App\Models\Exercise;
use App\Models\Training;
use App\Models\TrainingLog;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Carbon\Carbon;

class TrainingController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $trainings = Auth::user()->trainings()->with('daysOfWeek')->latest()->get();
        return view('trainings.index', compact('trainings'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        $daysOfWeek = DayOfWeek::all();
        return view('trainings.create', compact('daysOfWeek'));
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $validatedData = $request->validate([
            'name' => 'required|string|max:255',
            'description' => 'nullable|string',
            'days_of_week' => 'nullable|array',
            'days_of_week.*' => 'exists:day_of_weeks,id'
        ]);

        $training = Auth::user()->trainings()->create($validatedData);

        if ($request->has('days_of_week')) {
            $training->daysOfWeek()->attach($request->days_of_week);
        }

        return redirect()->route('trainings.index')->with('success', 'Treino criado com sucesso!');
    }

    /**
     * Display the specified resource.
     */
    public function show(Training $training)
    {
        if ($training->user_id !== Auth::id()) {
            abort(403);
        }

        $exercises = $training->exercises()->orderBy('order', 'asc')->get();

        return view('trainings.show', compact('training', 'exercises'));
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Training $training)
    {
        if ($training->user_id !== Auth::id()) {
            abort(403);
        }
        
        $daysOfWeek = DayOfWeek::all();
        $training->load('daysOfWeek'); 

        return view('trainings.edit', compact('training', 'daysOfWeek'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, Training $training)
    {
        if ($training->user_id !== Auth::id()) {
            abort(403);
        }

        $validatedData = $request->validate([
            'name' => 'required|string|max:255',
            'description' => 'nullable|string',
            'days_of_week' => 'nullable|array',
            'days_of_week.*' => 'exists:day_of_weeks,id'
        ]);

        $training->update($validatedData);

        $training->daysOfWeek()->sync($request->days_of_week ?? []);

        return redirect()->route('trainings.index')->with('success', 'Treino atualizado com sucesso!');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Training $training)
    {
        if ($training->user_id !== Auth::id()) {
            abort(403);
        }

        $training->delete();

        return redirect()->route('trainings.index')->with('success', 'Treino excluído com sucesso!');
    }

    // --- Métodos para Exercícios ---

    public function createExercise(Training $training)
    {
        if ($training->user_id !== Auth::id()) {
            abort(403);
        }

        return view('exercises.create', compact('training'));
    }

    public function storeExercise(Request $request, Training $training)
    {
        if ($training->user_id !== Auth::id()) {
            abort(403);
        }

        $validatedData = $request->validate([
            'name' => 'required|string|max:255',
            'sets' => 'required|integer|min:1',
            'reps' => 'required|string|max:255',
            'load' => 'nullable|numeric',
            'notes' => 'nullable|string',
        ]);

        $training->exercises()->create($validatedData);

        return redirect()->route('trainings.show', $training)->with('success', 'Exercício adicionado com sucesso!');
    }

    public function editExercise(Training $training, Exercise $exercise)
    {
        if ($training->user_id !== Auth::id() || $exercise->training_id !== $training->id) {
            abort(403);
        }

        return view('exercises.edit', compact('training', 'exercise'));
    }

    public function updateExercise(Request $request, Training $training, Exercise $exercise)
    {
        if ($training->user_id !== Auth::id() || $exercise->training_id !== $training->id) {
            abort(403);
        }
        $validatedData = $request->validate([
            'name' => 'required|string|max:255',
            'sets' => 'required|integer|min:1',
            'reps' => 'required|string|max:255',
            'load' => 'nullable|numeric',
            'notes' => 'nullable|string',
        ]);

        $exercise->update($validatedData);

        return redirect()->route('trainings.show', $training)->with('success', 'Exercício atualizado com sucesso!');
    }

    public function destroyExercise(Training $training, Exercise $exercise)
    {
        if ($training->user_id !== Auth::id() || $exercise->training_id !== $training->id) {
            abort(403);
        }

        $exercise->delete();

        return redirect()->route('trainings.show', $training)->with('success', 'Exercício excluído com sucesso!');
    }

    /**
     * Reorders the exercises for a given training.
     */
    public function reorderExercises(Request $request, Training $training)
    {
        if ($training->user_id !== Auth::id()) {
            return response()->json(['success' => false, 'message' => 'Não autorizado.'], 403);
        }

        $validated = $request->validate([
            'order' => 'required|array',
            'order.*' => 'integer|exists:exercises,id'
        ]);

        foreach ($validated['order'] as $index => $exerciseId) {
            // Garante que a atualização seja feita apenas para exercícios deste treino, por segurança
            $training->exercises()->where('id', $exerciseId)->update(['order' => $index + 1]);
        }

        return response()->json(['success' => true, 'message' => 'Ordem dos exercícios atualizada.']);
    }


    // --- Métodos para o Diário de Treinos ---

    public function completeSession(Request $request, Training $training)
    {
        if ($training->user_id !== Auth::id()) {
            abort(403);
        }

        $validated = $request->validate([
            'feedback' => 'nullable|string|max:5000',
        ]);

        $training->logs()->create([
            'user_id' => Auth::id(),
            'feedback' => $validated['feedback'],
            'completed_at' => Carbon::now(),
        ]);

        $message = 'Treino finalizado e salvo no seu histórico!';
        if (!empty($validated['feedback'])) {
            $message .= ' Seu feedback foi registrado. Obrigado!';
        }

        return redirect()->route('trainings.show', $training)
            ->with('success', $message);
    }

    public function history(Training $training)
    {
        if ($training->user_id !== Auth::id()) {
            abort(403);
        }
        
        $logs = $training->logs()->latest('completed_at')->paginate(10);

        return view('trainings.history', compact('training', 'logs'));
    }
}