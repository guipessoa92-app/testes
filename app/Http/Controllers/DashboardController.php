<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Traits\ProvidesMeasurementOptions;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Carbon\Carbon;

class DashboardController extends Controller
{
    use ProvidesMeasurementOptions;

    public function index()
    {
        $user = Auth::user();
        $measurementOptions = $this->getMeasurementOptions();

        // Bloco 1: Lógica do Próximo Treino
        $daysOfWeekMap = ['segunda' => 1, 'terca' => 2, 'quarta' => 3, 'quinta' => 4, 'sexta' => 5, 'sabado' => 6, 'domingo' => 7];
        $currentDayNumber = date('N');
        $nextTraining = null;
        for ($i = 0; $i < 7; $i++) {
            $dayToFind = ($currentDayNumber + $i - 1) % 7 + 1;
            $dayToFindPT = array_search($dayToFind, $daysOfWeekMap);
            $trainingOnDay = $user->trainings()->where('day_of_week', $dayToFindPT)->first();
            if ($trainingOnDay) {
                $nextTraining = $trainingOnDay;
                break;
            }
        }

        // Bloco 2: Lógica da Última Medição
        $latestMeasurement = $user->measurements()->latest('measurement_date')->first();

        // Bloco 3: Lógica do Gráfico Dinâmico e Composto
        $metricKey = $user->dashboard_metric ?? 'weight';
        $metricConfig = $measurementOptions[$metricKey] ?? $measurementOptions['weight'];
        $columnsToQuery = array_keys($metricConfig['columns']);

        $chartData = $user->measurements()
                          ->select(array_merge(['measurement_date'], $columnsToQuery))
                          ->where(function ($query) use ($columnsToQuery) {
                              // =================================================================
                              // == CORREÇÃO APLICADA AQUI ==
                              // Muda a condição para 'OU' (orWhereNotNull) para incluir
                              // registros mesmo que apenas um dos membros tenha sido preenchido.
                              // =================================================================
                              foreach ($columnsToQuery as $column) {
                                  $query->orWhereNotNull($column);
                              }
                          })
                          ->orderBy('measurement_date', 'asc')
                          ->get();

        $chartLabels = $chartData->map(fn($data) => Carbon::parse($data->measurement_date)->format('d/m'));
        
        $datasets = [];
        foreach ($metricConfig['columns'] as $column => $details) {
            $datasets[] = [
                'label' => $details['label'],
                'data' => $chartData->pluck($column),
                'borderColor' => $details['color'],
                'backgroundColor' => $details['color'] . '1a',
                'fill' => true,
                'tension' => 0.1,
            ];
        }

        // Bloco 4: Retorno para a View
        return view('dashboard', [
            'nextTraining' => $nextTraining,
            'latestMeasurement' => $latestMeasurement,
            'chartLabels' => $chartLabels,
            'datasets' => $datasets,
            'chartTitle' => $metricConfig['label'],
        ]);
    }
}