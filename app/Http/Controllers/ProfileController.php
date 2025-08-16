<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Traits\ProvidesMeasurementOptions;
use App\Http\Requests\ProfileUpdateRequest;
use App\Models\User; // Importa o modelo User
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Redirect;
use Illuminate\Validation\Rule;
use Illuminate\View\View;

class ProfileController extends Controller
{
    use ProvidesMeasurementOptions;

    /**
     * Display the user's profile form.
     */
    public function edit(Request $request): View
    {
        $user = $request->user();
        $personals = [];

        // Se o usuário logado for um aluno, busca a lista de todos os personals
        if ($user->role === 'aluno') {
            $personals = User::where('role', 'personal')->orderBy('name')->get();
        }

        return view('profile.edit', [
            'user' => $user,
            'measurementOptions' => $this->getMeasurementOptions(),
            'personals' => $personals, // Envia a lista de personals para a view
        ]);
    }

    /**
     * Update the user's profile information.
     */
    public function update(ProfileUpdateRequest $request): RedirectResponse
    {
        $user = $request->user();

        $user->fill($request->validated());

        if ($user->isDirty('email')) {
            $user->email_verified_at = null;
        }

        $user->save();

        return Redirect::route('profile.edit')
            ->with('status', 'profile-updated')
            ->with('success', 'Perfil atualizado com sucesso!');
    }
    
    /**
     * Update the user's dashboard preferences.
     */
    public function updatePreferences(Request $request): RedirectResponse
    {
        $measurementKeys = array_keys($this->getMeasurementOptions());
        $request->validate([
            'dashboard_metric' => ['required', 'string', 'in:' . implode(',', $measurementKeys)]
        ]);

        $user = $request->user();
        $user->dashboard_metric = $request->input('dashboard_metric');
        $user->save();

        return Redirect::route('profile.edit')
            ->with('status', 'preferences-updated')
            ->with('success', 'Preferência do dashboard salva com sucesso!');
    }

    /**
     * Link or unlink a personal trainer to the student's account.
     */
    public function linkPersonal(Request $request): RedirectResponse
    {
        $user = $request->user();

        // Garante que apenas alunos possam usar esta funcionalidade
        if ($user->role !== 'aluno') {
            abort(403, 'Apenas alunos podem se vincular a um personal.');
        }

        // Valida que o personal_id enviado existe na tabela users e tem o role 'personal'
        $request->validate([
            'personal_id' => [
                'nullable', // Permite desvincular enviando um valor nulo
                'integer',
                Rule::exists('users', 'id')->where(function ($query) {
                    $query->where('role', 'personal');
                }),
            ],
        ]);

        $user->personal_id = $request->input('personal_id');
        $user->save();

        $message = $request->input('personal_id') ? 'Personal vinculado com sucesso!' : 'Personal desvinculado com sucesso!';

        return Redirect::route('profile.edit')->with('success', $message);
    }
    
    /**
     * Delete the user's account.
     */
    public function destroy(Request $request): RedirectResponse
    {
        $request->validateWithBag('userDeletion', [
            'password' => ['required', 'current_password'],
        ]);

        $user = $request->user();

        Auth::logout();

        $user->delete();

        $request->session()->invalidate();
        $request->session()->regenerateToken();

        return Redirect::to('/');
    }
}