<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class FeedbackHistoryController extends Controller
{
    /**
     * Display a listing of all training feedbacks for the user.
     */
    public function index()
    {
        $user = Auth::user();

        // Busca todos os logs de treino que contêm feedback,
        // carrega a relação com o nome do treino para evitar N+1 queries,
        // e ordena do mais recente para o mais antigo.
        $feedbacks = $user->trainingLogs()
                          ->whereNotNull('feedback')
                          ->with('training') // Eager load the training relationship
                          ->latest('completed_at')
                          ->paginate(15); // Paginate the results

        return view('feedback.history', compact('feedbacks'));
    }
}