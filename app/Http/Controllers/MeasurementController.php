<?php

namespace App\Http\Controllers;

use App\Models\Measurement;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Carbon\Carbon;

class MeasurementController extends Controller
{
    public function index()
    {
        $measurements = Auth::user()->measurements()->latest('measurement_date')->get();
        return view('measurements.index', compact('measurements'));
    }

    public function create()
    {
        return view('measurements.create');
    }

    public function store(Request $request)
    {
        $validatedData = $request->validate([
            'measurement_date' => 'required|date',
            'weight' => 'nullable|numeric|min:0',
            'shoulders' => 'nullable|numeric|min:0',
            'chest' => 'nullable|numeric|min:0',
            'biceps_right_contracted' => 'nullable|numeric|min:0',
            'biceps_right_relaxed' => 'nullable|numeric|min:0',
            'biceps_left_contracted' => 'nullable|numeric|min:0',
            'biceps_left_relaxed' => 'nullable|numeric|min:0',
            'forearm_right' => 'nullable|numeric|min:0',
            'forearm_left' => 'nullable|numeric|min:0',
            'waist' => 'nullable|numeric|min:0',
            'abdomen' => 'nullable|numeric|min:0',
            'hips' => 'nullable|numeric|min:0',
            'gluteos' => 'nullable|numeric|min:0',
            'thigh_right' => 'nullable|numeric|min:0',
            'thigh_left' => 'nullable|numeric|min:0',
            'calf_right' => 'nullable|numeric|min:0',
            'calf_left' => 'nullable|numeric|min:0',
            'age' => 'nullable|integer|min:0',
            'sex' => 'nullable|string',
            'pectorals' => 'nullable|numeric|min:0',
            'midaxillary' => 'nullable|numeric|min:0',
            'triceps' => 'nullable|numeric|min:0',
            'subscapular' => 'nullable|numeric|min:0',
            'abdominal' => 'nullable|numeric|min:0',
            'suprailiac' => 'nullable|numeric|min:0',
            'notes' => 'nullable|string',
        ]);

        Auth::user()->measurements()->create($validatedData);

        return redirect()->route('measurements.index')->with('success', 'Medidas salvas com sucesso!');
    }

    public function show(Measurement $measurement)
    {
        if ($measurement->user_id !== Auth::id()) {
            abort(403);
        }
        return view('measurements.show', compact('measurement'));
    }

    public function edit(Measurement $measurement)
    {
        if ($measurement->user_id !== Auth::id()) {
            abort(403);
        }
        return view('measurements.edit', compact('measurement'));
    }

    public function update(Request $request, Measurement $measurement)
    {
        if ($measurement->user_id !== Auth::id()) {
            abort(403);
        }
        $validatedData = $request->validate([
            'measurement_date' => 'required|date',
            'weight' => 'nullable|numeric|min:0',
            'shoulders' => 'nullable|numeric|min:0',
            'chest' => 'nullable|numeric|min:0',
            'biceps_right_contracted' => 'nullable|numeric|min:0',
            'biceps_right_relaxed' => 'nullable|numeric|min:0',
            'biceps_left_contracted' => 'nullable|numeric|min:0',
            'biceps_left_relaxed' => 'nullable|numeric|min:0',
            'forearm_right' => 'nullable|numeric|min:0',
            'forearm_left' => 'nullable|numeric|min:0',
            'waist' => 'nullable|numeric|min:0',
            'abdomen' => 'nullable|numeric|min:0',
            'hips' => 'nullable|numeric|min:0',
            'gluteos' => 'nullable|numeric|min:0',
            'thigh_right' => 'nullable|numeric|min:0',
            'thigh_left' => 'nullable|numeric|min:0',
            'calf_right' => 'nullable|numeric|min:0',
            'calf_left' => 'nullable|numeric|min:0',
            'age' => 'nullable|integer|min:0',
            'sex' => 'nullable|string',
            'pectorals' => 'nullable|numeric|min:0',
            'midaxillary' => 'nullable|numeric|min:0',
            'triceps' => 'nullable|numeric|min:0',
            'subscapular' => 'nullable|numeric|min:0',
            'abdominal' => 'nullable|numeric|min:0',
            'suprailiac' => 'nullable|numeric|min:0',
            'notes' => 'nullable|string',
        ]);

        $measurement->update($validatedData);
        return redirect()->route('measurements.index')->with('success', 'Medida atualizada com sucesso!');
    }

    public function destroy(Measurement $measurement)
    {
        if ($measurement->user_id !== Auth::id()) {
            abort(403);
        }
        $measurement->delete();
        return redirect()->route('measurements.index')->with('success', 'Medida excluída com sucesso!');
    }

    public function progress(Request $request)
    {
        $measurementType = $request->get('medida', 'weight');
        $filterMode = $request->get('filter_mode', 'period');
        $period = $request->get('periodo', 12);
        $month = $request->get('month', null);
        $year = $request->get('year', null);

        $query = Auth::user()->measurements();

        if ($filterMode === 'custom' && ($month || $year)) {
            if ($year) {
                $query->whereYear('measurement_date', $year);
            }
            if ($month) {
                $query->whereMonth('measurement_date', $month);
            }
        } else {
            $dateLimit = Carbon::now()->subMonths($period);
            $query->where('measurement_date', '>=', $dateLimit);
        }
        
        $measurements = $query->oldest('measurement_date')->get();
        
        $labels = $measurements->pluck('measurement_date')->map(fn($date) => Carbon::parse($date)->format('d/m/Y'));
        
        // Mapeamento de nomes para exibir nos gráficos
        $measurementLabels = [
            'weight' => 'Peso',
            'shoulders' => 'Ombros',
            'chest' => 'Peito',
            'waist' => 'Cintura',
            'hips' => 'Quadril',
            'gluteos' => 'Glúteos',
            'thigh_right' => 'Coxa Direita',
            'thigh_left' => 'Coxa Esquerda',
            'calf_right' => 'Panturrilha Direita',
            'calf_left' => 'Panturrilha Esquerda',
            'biceps_right_contracted' => 'Bíceps Direito (Contraído)',
            'biceps_right_relaxed' => 'Bíceps Direito (Relaxado)',
            'biceps_left_contracted' => 'Bíceps Esquerdo (Contraído)',
            'biceps_left_relaxed' => 'Bíceps Esquerdo (Relaxado)',
            'forearm_right' => 'Antebraço Direito',
            'forearm_left' => 'Antebraço Esquerdo',
        ];

        $dataset = [
            'label' => $measurementLabels[$measurementType] ?? $measurementType,
            'data' => $measurements->pluck($measurementType),
            'borderColor' => '#3b82f6',
            'tension' => 0.4
        ];
        
        $measurementOptions = $measurementLabels;

        $allMeasurements = Auth::user()->measurements()->latest('measurement_date')->get();
        $availableYears = $allMeasurements->pluck('measurement_date')->map(fn($date) => Carbon::parse($date)->format('Y'))->unique()->sortDesc();
        $availableMonths = [
            '01' => 'Janeiro', '02' => 'Fevereiro', '03' => 'Março', '04' => 'Abril',
            '05' => 'Maio', '06' => 'Junho', '07' => 'Julho', '08' => 'Agosto',
            '09' => 'Setembro', '10' => 'Outubro', '11' => 'Novembro', '12' => 'Dezembro'
        ];

        return view('measurements.progress', compact('labels', 'dataset', 'measurementOptions', 'measurementType', 'availableYears', 'availableMonths', 'month', 'year', 'period', 'filterMode'));
    }
}