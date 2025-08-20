<?php

namespace App\Http\Controllers;

use App\Models\DayOfWeek; // Importa o modelo DayOfWeek
use App\Models\Exercise;
use App\Models\Training;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\View\View;

class PersonalController extends Controller
{
    /**
     * Exibe a lista de alunos vinculados ao personal trainer logado.
     */
    public function index(): View
    {
        $personal = Auth::user();
        $alunos = $personal->alunos()->orderBy('name')->paginate(15);
        return view('personal.students.index', compact('alunos'));
    }

    /**
     * Exibe a lista de treinos de um aluno específico para o personal.
     */
    public function showStudentTrainings(User $aluno): View
    {
        if ($aluno->personal_id !== Auth::id()) {
            abort(403, 'Acesso não autorizado a este aluno.');
        }
        $trainings = $aluno->trainings()->with('daysOfWeek')->latest()->get();
        return view('personal.students.trainings', compact('aluno', 'trainings'));
    }

    // =========================================================================
    // == NOVOS MÉTODOS ADICIONADOS ==
    // =========================================================================

    /**
     * Mostra o formulário para o personal criar um novo treino para um aluno.
     */
    public function createStudentTraining(User $aluno): View
    {
        if ($aluno->personal_id !== Auth::id()) {
            abort(403, 'Acesso não autorizado a este aluno.');
        }

        $daysOfWeek = DayOfWeek::all();
        return view('personal.students.trainings.create', compact('aluno', 'daysOfWeek'));
    }

    /**
     * Salva o novo treino criado pelo personal para o aluno.
     */
    public function storeStudentTraining(Request $request, User $aluno)
    {
        if ($aluno->personal_id !== Auth::id()) {
            abort(403, 'Acesso não autorizado a este aluno.');
        }

        $validatedData = $request->validate([
            'name' => 'required|string|max:255',
            'description' => 'nullable|string',
            'days_of_week' => 'nullable|array',
            'days_of_week.*' => 'exists:day_of_weeks,id'
        ]);
        
        // Cria o treino associando-o DIRETAMENTE ao ID do aluno
        $training = $aluno->trainings()->create($validatedData);

        if ($request->has('days_of_week')) {
            $training->daysOfWeek()->attach($request->days_of_week);
        }

        return redirect()->route('personal.students.trainings', $aluno)
            ->with('success', 'Treino criado para ' . $aluno->name . ' com sucesso!');
    }

    /**
     * Exibe os detalhes de um treino específico de um aluno.
     */
    public function showStudentTrainingDetails(User $aluno, Training $training): View
    {
        if ($aluno->personal_id !== Auth::id() || $training->user_id !== $aluno->id) {
            abort(403, 'Acesso não autorizado.');
        }

        $training->load('exercises'); // Carrega os exercícios associados ao treino

        return view('personal.students.trainings.show', compact('aluno', 'training'));
    }

    /**
     * Mostra o formulário para criar um novo exercício para um treino de um aluno.
     */
    public function createStudentExercise(User $aluno, Training $training): View
    {
        // Lógica de autorização
        if ($aluno->personal_id !== Auth::id() || $training->user_id !== $aluno->id) {
            abort(403, 'Acesso não autorizado.');
        }

        // Retorna a view do formulário de criação de exercício
        return view('personal.students.exercises.create', compact('aluno', 'training'));
    }

    /**
     * Salva um novo exercício no treino de um aluno.
     */
    public function storeStudentExercise(Request $request, User $aluno, Training $training)
    {
        // Lógica de autorização
        if ($aluno->personal_id !== Auth::id() || $training->user_id !== $aluno->id) {
            abort(403, 'Acesso não autorizado.');
        }

        $validatedData = $request->validate([
            'name' => 'required|string|max:255',
            'description' => 'nullable|string',
            'reps' => 'nullable|string',
            'sets' => 'nullable|integer',
            'load' => 'nullable|numeric',
            'rest_time' => 'nullable|string',
            'notes' => 'nullable|string',
        ]);

        $training->exercises()->create($validatedData);

        return redirect()->route('personal.students.trainings.show', [$aluno, $training])
            ->with('success', 'Exercício adicionado com sucesso!');
    }

    /**
     * Mostra o formulário para editar um exercício de um treino de um aluno.
     */
    public function editStudentExercise(User $aluno, Training $training, Exercise $exercise): View
    {
        // Lógica de autorização
        if ($aluno->personal_id !== Auth::id() || $training->user_id !== $aluno->id || $exercise->training_id !== $training->id) {
            abort(403, 'Acesso não autorizado.');
        }

        return view('personal.students.exercises.edit', compact('aluno', 'training', 'exercise'));
    }

    /**
     * Atualiza um exercício no treino de um aluno.
     */
    public function updateStudentExercise(Request $request, User $aluno, Training $training, Exercise $exercise)
    {
        // Lógica de autorização
        if ($aluno->personal_id !== Auth::id() || $training->user_id !== $aluno->id || $exercise->training_id !== $training->id) {
            abort(403, 'Acesso não autorizado.');
        }

        $validatedData = $request->validate([
            'name' => 'required|string|max:255',
            'description' => 'nullable|string',
            'reps' => 'nullable|string',
            'sets' => 'nullable|integer',
            'load' => 'nullable|numeric',
            'rest_time' => 'nullable|string',
            'notes' => 'nullable|string',
        ]);

        $exercise->update($validatedData);

        return redirect()->route('personal.students.trainings.show', [$aluno, $training])
            ->with('success', 'Exercício atualizado com sucesso!');
    }

    /**
     * Remove um exercício do treino de um aluno.
     */
    public function destroyStudentExercise(User $aluno, Training $training, Exercise $exercise)
    {
        // Lógica de autorização
        if ($aluno->personal_id !== Auth::id() || $training->user_id !== $aluno->id || $exercise->training_id !== $training->id) {
            abort(403, 'Acesso não autorizado.');
        }

        $exercise->delete();

        return redirect()->route('personal.students.trainings.show', [$aluno, $training])
            ->with('success', 'Exercício removido com sucesso!');
    }
}