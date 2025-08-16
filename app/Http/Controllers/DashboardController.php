<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Traits\ProvidesMeasurementOptions;
use App\Models\DayOfWeek; // Importa o modelo DayOfWeek para mapear os dias
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

        // =========================================================================
        // == LÓGICA DO PRÓXIMO TREINO CORRIGIDA E MELHORADA ==
        // =========================================================================
        $nextTraining = null;
        $nextTrainingDayName = null; // <-- Variável para guardar o nome do dia
        $todayId = Carbon::now()->dayOfWeekIso; // 1 = Segunda, 7 = Domingo

        $allTrainings = $user->trainings()->with('daysOfWeek')->get();
        $daysOfWeekMap = DayOfWeek::all()->keyBy('id'); // Mapeia IDs para nomes (ex: 1 => 'segunda')

        for ($i = 0; $i < 7; $i++) {
            $dayToFindId = ($todayId + $i - 1) % 7 + 1;

            foreach ($allTrainings as $training) {
                if ($training->daysOfWeek->pluck('id')->contains($dayToFindId)) {
                    $nextTraining = $training;
                    // Encontramos o dia, agora pegamos o nome dele no nosso mapa
                    $nextTrainingDayName = $daysOfWeekMap->get($dayToFindId)->name;
                    break 2; // Sai dos dois loops
                }
            }
        }

        // Bloco 2: Lógica da Última Medição (Preservada)
        $latestMeasurement = $user->measurements()->latest('measurement_date')->first();

        // Bloco 3: Lógica do Gráfico Dinâmico e Composto (Preservada)
        $metricKey = $user->dashboard_metric ?? 'weight';
        $metricConfig = $measurementOptions[$metricKey] ?? $measurementOptions['weight'];
        $columnsToQuery = array_keys($metricConfig['columns']);

        $chartData = $user->measurements()
                          ->select(array_merge(['measurement_date'], $columnsToQuery))
                          ->where(function ($query) use ($columnsToQuery) {
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

        // Bloco 4: Retorno para a View (Preservado e com a nova variável)
        return view('dashboard', [
            'nextTraining' => $nextTraining,
            'nextTrainingDayName' => $nextTrainingDayName, // <-- Envia o nome do dia para a view
            'latestMeasurement' => $latestMeasurement,
            'chartLabels' => $chartLabels,
            'datasets' => $datasets,
            'chartTitle' => $metricConfig['label'],
        ]);
    }
}