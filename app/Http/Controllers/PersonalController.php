<?php

namespace App\Http\Controllers;

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
        // Pega o usuário logado (que deve ser um personal, garantido pela rota)
        $personal = Auth::user();

        // Usa a relação 'alunos' que definimos no modelo User para buscar os alunos
        $alunos = $personal->alunos()->orderBy('name')->paginate(15);

        return view('personal.students.index', compact('alunos'));
    }
}