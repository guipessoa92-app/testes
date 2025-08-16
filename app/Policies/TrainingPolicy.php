<?php

namespace App\Policies;

use App\Models\Training;
use App\Models\User;
use Illuminate\Auth\Access\Response;

class TrainingPolicy
{
    /**
     * Determine whether the user can view any models.
     * Alunos e Personals podem ver a sua própria lista de treinos.
     */
    public function viewAny(User $user): bool
    {
        return true;
    }

    /**
     * Determine whether the user can view the model.
     * Um usuário pode ver um treino se:
     * 1. O treino pertence a ele.
     * 2. Ele é um personal e o treino pertence a um de seus alunos.
     */
    public function view(User $user, Training $training): bool
    {
        // Se o usuário é o dono do treino
        if ($user->id === $training->user_id) {
            return true;
        }

        // Se o usuário é um personal e o dono do treino é seu aluno
        if ($user->role === 'personal' && $training->user->personal_id === $user->id) {
            return true;
        }

        return false;
    }

    /**
     * Determine whether the user can create models.
     * Qualquer usuário logado pode criar seus próprios treinos.
     */
    public function create(User $user): bool
    {
        return true;
    }

    /**
     * Determine whether the user can update the model.
     * A lógica é a mesma de 'view'.
     */
    public function update(User $user, Training $training): bool
    {
        // Se o usuário é o dono do treino
        if ($user->id === $training->user_id) {
            return true;
        }

        // Se o usuário é um personal e o dono do treino é seu aluno
        if ($user->role === 'personal' && $training->user->personal_id === $user->id) {
            return true;
        }

        return false;
    }

    /**
     * Determine whether the user can delete the model.
     * A lógica é a mesma de 'view' e 'update'.
     */
    public function delete(User $user, Training $training): bool
    {
        // Se o usuário é o dono do treino
        if ($user->id === $training->user_id) {
            return true;
        }

        // Se o usuário é um personal e o dono do treino é seu aluno
        if ($user->role === 'personal' && $training->user->personal_id === $user->id) {
            return true;
        }

        return false;
    }

    /**
     * Determine whether the user can restore the model.
     */
    public function restore(User $user, Training $training): bool
    {
        return false; // Não estamos usando esta funcionalidade
    }

    /**
     * Determine whether the user can permanently delete the model.
     */
    public function forceDelete(User $user, Training $training): bool
    {
        return false; // Não estamos usando esta funcionalidade
    }
}