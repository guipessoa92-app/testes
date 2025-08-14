<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            {{ __('Seu Painel de Controle') }}
        </h2>
    </x-slot>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="grid grid-cols-1 lg:grid-cols-3 gap-6">

                <div class="lg:col-span-2 space-y-6">
                    <div class="bg-white p-6 rounded-lg shadow-md">
                        <h3 class="text-xl font-bold text-gray-900 mb-4">🗓️ Próximo Treino</h3>
                        @if ($nextTraining)
                            <div class="p-4 bg-gray-50 rounded-md">
                                <p class="text-lg font-bold text-indigo-600">{{ $nextTraining->name }}</p>
                                <p class="text-gray-600 mt-1">Dia: <span class="font-semibold">{{ ucfirst($nextTraining->day_of_week) }}</span></p>
                                <a href="{{ route('trainings.show', $nextTraining) }}" class="mt-4 inline-block bg-indigo-500 text-white hover:bg-indigo-600 font-bold py-2 px-4 rounded transition duration-300">
                                    Iniciar Treino
                                </a>
                            </div>
                        @else
                            <div class="p-4 bg-gray-50 rounded-md text-gray-500">
                                <p>Nenhum treino agendado para os próximos dias. Que tal planejar sua semana?</p>
                                <a href="{{ route('trainings.create') }}" class="mt-4 inline-block text-indigo-500 hover:underline">Criar novo treino</a>
                            </div>
                        @endif
                    </div>

                    <div class="bg-white p-6 rounded-lg shadow-md">
                        <h3 class="text-xl font-bold text-gray-900 mb-4">📊 Progresso de {{ $chartTitle }}</h3>
                        <div class="h-64 flex items-center justify-center">
                            @if ($chartLabels->count() > 1)
                                <canvas id="dashboardChart"></canvas>
                            @elseif ($chartLabels->count() == 1)
                                <div class="text-center text-gray-500">
                                    <p>Ótimo começo! Adicione mais uma medição de {{ strtolower($chartTitle) }} para começar a ver seu progresso no gráfico.</p>
                                </div>
                            @else
                                <div class="text-center text-gray-500">
                                    <p>Nenhuma medição de {{ strtolower($chartTitle) }} encontrada para exibir no gráfico.</p>
                                    <a href="{{ route('measurements.create') }}" class="mt-2 inline-block text-indigo-500 hover:underline">Adicionar sua primeira medição</a>
                                </div>
                            @endif
                        </div>
                    </div>
                </div>

                <div class="space-y-6">
                    <div class="bg-white p-6 rounded-lg shadow-md">
                        <h3 class="text-xl font-bold text-gray-900 mb-2">📏 Última Medição</h3>
                        @if ($latestMeasurement)
                            <p class="text-sm text-gray-500 mb-4">Registrado em: {{ $latestMeasurement->created_at->format('d/m/Y') }}</p>
                            <ul class="space-y-2 text-sm">
                                <li class="flex justify-between"><span>Peso:</span> <span class="font-bold">{{ $latestMeasurement->weight ?? '-' }} kg</span></li>
                                <li class="flex justify-between"><span>Peito:</span> <span class="font-bold">{{ $latestMeasurement->chest ?? '-' }} cm</span></li>
                                <li class="flex justify-between"><span>Cintura:</span> <span class="font-bold">{{ $latestMeasurement->waist ?? '-' }} cm</span></li>
                            </ul>
                            <a href="{{ route('measurements.index') }}" class="mt-4 inline-block text-indigo-500 hover:underline text-sm">Ver todas as medidas</a>
                        @else
                            <p class="text-gray-500">Nenhuma medida registrada ainda.</p>
                        @endif
                    </div>

                    <div class="bg-white p-6 rounded-lg shadow-md">
                        <h3 class="text-xl font-bold text-gray-900 mb-4">⚡ Ações Rápidas</h3>
                        <div class="space-y-3">
                            <a href="{{ route('measurements.create') }}" class="block w-full text-center bg-green-500 text-white hover:bg-green-600 font-bold py-2 px-4 rounded transition duration-300">Adicionar Medição</a>
                            <a href="{{ route('trainings.index') }}" class="block w-full text-center bg-blue-500 text-white hover:bg-blue-600 font-bold py-2 px-4 rounded transition duration-300">Ver Fichas de Treino</a>
                            <a href="{{ route('measurements.progress') }}" class="block w-full text-center bg-purple-500 text-white hover:bg-purple-600 font-bold py-2 px-4 rounded transition duration-300">Ver Progresso Completo</a>
                        </div>
                    </div>
                </div>

            </div>
        </div>
    </div>

    @push('scripts')
    <script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
    <script>
        if (document.getElementById('dashboardChart')) {
            const ctx = document.getElementById('dashboardChart');
            const chartLabels = @json($chartLabels);
            const datasets = @json($datasets);

            new Chart(ctx, {
                type: 'line',
                data: {
                    labels: chartLabels,
                    datasets: datasets
                },
                options: {
                    responsive: true,
                    maintainAspectRatio: false,
                    scales: { y: { beginAtZero: false } }
                }
            });
        }
    </script>
    @endpush
</x-app-layout>