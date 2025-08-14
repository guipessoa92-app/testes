<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            {{ __('Minhas Medidas Corporais') }}
        </h2>
    </x-slot>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
                <div class="p-6 text-gray-900">
                    <div class="flex justify-between items-center mb-6">
                        <h3 class="text-2xl font-bold text-gray-900">Histórico de Medidas</h3>
                        <a href="{{ route('measurements.create') }}" class="inline-flex items-center px-4 py-2 bg-green-500 border border-transparent rounded-md font-semibold text-xs text-white uppercase tracking-widest hover:bg-green-600 focus:outline-none focus:ring-2 focus:ring-green-500 focus:ring-offset-2 transition ease-in-out duration-150">
                            <svg class="w-4 h-4 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4v16m8-8H4"></path></svg>
                            Adicionar Medida
                        </a>
                    </div>

                    @if ($measurements->count())
                        <div class="mt-4 overflow-x-auto">
                            <table class="min-w-full divide-y divide-gray-200">
                                <thead>
                                    <tr>
                                        <th class="px-6 py-3 bg-gray-50 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Data</th>
                                        <th class="px-6 py-3 bg-gray-50 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Peso</th>
                                        <th class="px-6 py-3 bg-gray-50 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Bíceps Relaxado</th>
                                        <th class="px-6 py-3 bg-gray-50 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Cintura</th>
                                        <th class="px-6 py-3 bg-gray-50 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Ações</th>
                                    </tr>
                                </thead>
                                <tbody class="bg-white divide-y divide-gray-200">
                                    @foreach ($measurements as $measurement)
                                        <tr>
                                            <td class="px-6 py-4 whitespace-nowrap">{{ \Carbon\Carbon::parse($measurement->measurement_date)->format('d/m/Y') }}</td>
                                            <td class="px-6 py-4 whitespace-nowrap">{{ $measurement->weight ? $measurement->weight . ' kg' : '-' }}</td>
                                            
                                            <td class="px-6 py-4 whitespace-nowrap">
                                                @php
                                                    $bicepsDisplay = [];
                                                    if ($measurement->biceps_right_relaxed) {
                                                        $bicepsDisplay[] = "D: " . $measurement->biceps_right_relaxed . " cm";
                                                    }
                                                    if ($measurement->biceps_left_relaxed) {
                                                        $bicepsDisplay[] = "E: " . $measurement->biceps_left_relaxed . " cm";
                                                    }
                                                @endphp
                                                {{ implode(' / ', $bicepsDisplay) ?: '-' }}
                                            </td>
                                            
                                            <td class="px-6 py-4 whitespace-nowrap">{{ $measurement->waist ? $measurement->waist . ' cm' : '-' }}</td>
                                            <td class="px-6 py-4 whitespace-nowrap text-sm font-medium">
                                                <div class="flex items-center space-x-4">
                                                    <a href="{{ route('measurements.show', $measurement) }}" class="text-indigo-600 hover:text-indigo-900">Visualizar</a>
                                                    <a href="{{ route('measurements.edit', $measurement) }}" class="text-blue-600 hover:text-blue-900">Editar</a>
                                                    <form action="{{ route('measurements.destroy', $measurement) }}" method="POST" onsubmit="return confirm('Tem certeza que deseja excluir esta medida?');">
                                                        @csrf
                                                        @method('DELETE')
                                                        <button type="submit" class="text-red-600 hover:text-red-900">Excluir</button>
                                                    </form>
                                                </div>
                                            </td>
                                        </tr>
                                    @endforeach
                                </tbody>
                            </table>
                        </div>
                    @else
                        <div class="text-center py-10">
                            <p class="text-gray-600">Nenhuma medida registrada ainda. Clique em "Adicionar Medida" para começar!</p>
                        </div>
                    @endif
                </div>
            </div>
        </div>
    </div>
</x-app-layout>