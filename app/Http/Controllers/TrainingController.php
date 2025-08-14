<?php

namespace App\Http\Controllers;

use App\Models\Exercise;
use App\Models\Training;
use App\Models\TrainingLog; // Importa o novo modelo
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
        $trainings = Auth::user()->trainings()->latest()->get();

        return view('trainings.index', compact('trainings'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        return view('trainings.create');
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $validatedData = $request->validate([
            'name' => 'required|string|max:255',
            'day_of_week' => 'nullable|string|max:255',
            'description' => 'nullable|string',
        ]);

        Auth::user()->trainings()->create($validatedData);

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

        return view('trainings.edit', compact('training'));
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
            'day_of_week' => 'nullable|string|max:255',
            'description' => 'nullable|string',
        ]);

        $training->update($validatedData);

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

    // =========================================================================
    // == NOVOS MÉTODOS PARA O DIÁRIO DE TREINOS ==
    // =========================================================================

    /**
     * Salva um novo registro de treino (sessão) com feedback opcional.
     */
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

        return redirect()->route('trainings.show', $training)
            ->with('success', 'Treino finalizado e salvo no seu histórico!');
    }

    /**
     * Mostra o histórico de sessões e feedbacks de um treino.
     */
    public function history(Training $training)
    {
        if ($training->user_id !== Auth::id()) {
            abort(403);
        }
        
        $logs = $training->logs()->latest('completed_at')->paginate(10);

        return view('trainings.history', compact('training', 'logs'));
    }
}