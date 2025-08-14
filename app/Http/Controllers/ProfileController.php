<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Traits\ProvidesMeasurementOptions; // Importa o Trait
use App\Http\Requests\ProfileUpdateRequest;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Redirect;
use Illuminate\View\View;

class ProfileController extends Controller
{
    use ProvidesMeasurementOptions; // Usa o Trait

    public function edit(Request $request): View
    {
        return view('profile.edit', [
            'user' => $request->user(),
            'measurementOptions' => $this->getMeasurementOptions(), // Envia as opções para a view
        ]);
    }

    public function update(ProfileUpdateRequest $request): RedirectResponse
    {
        // ... (código inalterado)
    }
    
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
    
    public function destroy(Request $request): RedirectResponse
    {
        // ... (código inalterado)
    }
}