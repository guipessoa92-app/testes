<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use App\Models\Measurement;
use Carbon\Carbon;

class ProgressController extends Controller
{
    public function index()
    {
        $measurements = Auth::user()->measurements()->latest('measurement_date')->get();

        $labels = $measurements->map(function ($measurement) {
            return Carbon::parse($measurement->measurement_date)->format('d/m/Y');
        })->reverse()->values();

        $datasets = [
            'weight' => [
                'label' => 'Peso (kg)',
                'data' => $measurements->reverse()->pluck('weight')->values(),
                'borderColor' => '#3b82f6',
                'tension' => 0.4
            ],
            'chest' => [
                'label' => 'Peito (cm)',
                'data' => $measurements->reverse()->pluck('chest')->values(),
                'borderColor' => '#10b981',
                'tension' => 0.4
            ],
            'waist' => [
                'label' => 'Cintura (cm)',
                'data' => $measurements->reverse()->pluck('waist')->values(),
                'borderColor' => '#ef4444',
                'tension' => 0.4
            ],
            'biceps_left_relaxed' => [
                'label' => 'Bíceps Esquerdo Relaxado (cm)',
                'data' => $measurements->reverse()->pluck('biceps_left_relaxed')->values(),
                'borderColor' => '#6366f1',
                'tension' => 0.4
            ],
            'thigh_left' => [
                'label' => 'Coxa Esquerda (cm)',
                'data' => $measurements->reverse()->pluck('thigh_left')->values(),
                'borderColor' => '#f97316',
                'tension' => 0.4
            ],
        ];

        $filteredDatasets = collect($datasets)->filter(function ($dataset) {
            return $dataset['data']->filter()->isNotEmpty();
        });

        return view('measurements.progress', [ // <-- Caminho da view corrigido aqui
            'labels' => $labels,
            'datasets' => $filteredDatasets,
        ]);
    }
}