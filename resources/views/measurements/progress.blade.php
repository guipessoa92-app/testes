<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            {{ __('Meu Progresso') }}
        </h2>
    </x-slot>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
                <div class="p-6 text-gray-900">
                    <div class="flex items-center mb-4">
                        <a href="{{ route('dashboard') }}" class="inline-flex items-center px-4 py-2 bg-gray-200 border border-transparent rounded-md font-semibold text-xs text-gray-800 uppercase tracking-widest hover:bg-gray-300 focus:outline-none focus:ring-2 focus:ring-gray-400 focus:ring-offset-2 transition ease-in-out duration-150">
                            <svg class="w-4 h-4 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 19l-7-7m0 0l7-7m-7 7h18"></path></svg>
                            Voltar
                        </a>
                    </div>
                    
                    <h3 class="text-lg font-medium text-gray-900 mb-4">Gráficos de Progresso</h3>

                    <form method="GET" action="{{ route('measurements.progress') }}" class="mb-6 flex flex-col md:flex-row items-center gap-4" x-data="{ filterMode: '{{ $filterMode }}' }">
                        {{-- Filtro de Medida --}}
                        <div>
                            <x-input-label for="medida" value="Medida" />
                            <select id="medida" name="medida" class="mt-1 block w-full rounded-md shadow-sm border-gray-300 focus:border-indigo-300 focus:ring focus:ring-indigo-200 focus:ring-opacity-50">
                                @foreach ($measurementOptions as $key => $label)
                                    <option value="{{ $key }}" @if($key === $measurementType) selected @endif>{{ $label }}</option>
                                @endforeach
                            </select>
                        </div>
                        
                        {{-- Seletor de Modo de Filtro --}}
                        <div>
                            <x-input-label for="filter_mode" value="Modo de Filtro" />
                            <select id="filter_mode" name="filter_mode" x-model="filterMode" class="mt-1 block w-full rounded-md shadow-sm border-gray-300 focus:border-indigo-300 focus:ring focus:ring-indigo-200 focus:ring-opacity-50">
                                <option value="period">Por Período</option>
                                <option value="custom">Por Mês/Ano</option>
                            </select>
                        </div>

                        {{-- Filtro de Período --}}
                        <div x-show="filterMode === 'period'">
                            <x-input-label for="periodo" value="Período" />
                            <select id="periodo" name="periodo" class="mt-1 block w-full rounded-md shadow-sm border-gray-300 focus:border-indigo-300 focus:ring focus:ring-indigo-200 focus:ring-opacity-50">
                                <option value="3" @if($period == 3) selected @endif>Últimos 3 meses</option>
                                <option value="6" @if($period == 6) selected @endif>Últimos 6 meses</option>
                                <option value="9" @if($period == 9) selected @endif>Últimos 9 meses</option>
                                <option value="12" @if($period == 12) selected @endif>Últimos 12 meses</option>
                            </select>
                        </div>

                        {{-- Filtro por Mês/Ano --}}
                        <div x-show="filterMode === 'custom'" class="flex gap-2">
                            <div>
                                <x-input-label for="month" value="Mês" />
                                <select id="month" name="month" class="mt-1 block w-full rounded-md shadow-sm border-gray-300 focus:border-indigo-300 focus:ring focus:ring-indigo-200 focus:ring-opacity-50">
                                    <option value="">Todos</option>
                                    @foreach ($availableMonths as $key => $label)
                                        <option value="{{ $key }}" @if($key == $month) selected @endif>{{ $label }}</option>
                                    @endforeach
                                </select>
                            </div>
                            <div>
                                <x-input-label for="year" value="Ano" />
                                <select id="year" name="year" class="mt-1 block w-full rounded-md shadow-sm border-gray-300 focus:border-indigo-300 focus:ring focus:ring-indigo-200 focus:ring-opacity-50">
                                    <option value="">Todos</option>
                                    @foreach ($availableYears as $value)
                                        <option value="{{ $value }}" @if($value == $year) selected @endif>{{ $value }}</option>
                                    @endforeach
                                </select>
                            </div>
                        </div>

                        <div class="self-end md:self-end mt-2 md:mt-0">
                            <x-primary-button>
                                {{ __('Filtrar') }}
                            </x-primary-button>
                        </div>
                    </form>

                    @if ($labels->isEmpty())
                        <p class="text-gray-600">Nenhuma medida registrada no período selecionado.</p>
                    @else
                        <div class="bg-gray-50 p-4 rounded-lg shadow-md">
                            <h4 class="text-lg font-semibold mb-2">Histórico de {{ $dataset['label'] }}</h4>
                            <canvas id="myChart"></canvas>
                        </div>
                    @endif
                </div>
            </div>
        </div>
    </div>

    @push('scripts')
    <script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
    <script>
        document.addEventListener('DOMContentLoaded', function() {
            const labels = @json($labels);
            const dataset = @json($dataset);
            
            const ctx = document.getElementById('myChart');
            
            if (ctx) {
                new Chart(ctx, {
                    type: 'line',
                    data: {
                        labels: labels,
                        datasets: [{
                            label: dataset.label,
                            data: dataset.data,
                            borderColor: dataset.borderColor,
                            tension: dataset.tension,
                            fill: false
                        }]
                    },
                    options: {
                        responsive: true,
                        plugins: {
                            legend: {
                                position: 'top',
                            },
                            title: {
                                display: true,
                                text: dataset.label + ' Histórico'
                            }
                        },
                        scales: {
                            y: {
                                beginAtZero: true
                            }
                        },
                    },
                });
            }
        });
    </script>
    @endpush
</x-app-layout>