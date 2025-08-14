<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            {{ __('Histórico do Treino: ') . $training->name }}
        </h2>
    </x-slot>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
                <div class="p-6 text-gray-900">
                    <div class="flex items-center mb-6">
                        <a href="{{ route('trainings.show', $training) }}" class="inline-flex items-center px-4 py-2 bg-gray-200 border border-transparent rounded-md font-semibold text-xs text-gray-800 uppercase tracking-widest hover:bg-gray-300">
                            <svg class="w-4 h-4 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 19l-7-7m0 0l7-7m-7 7h18"></path></svg>
                            Voltar para o Treino
                        </a>
                    </div>

                    <div class="space-y-6">
                        @forelse ($logs as $log)
                            <div class="p-4 border border-gray-200 rounded-lg">
                                <p class="font-semibold text-gray-800">
                                    Finalizado em: {{ $log->completed_at->format('d/m/Y \à\s H:i') }}
                                </p>
                                @if ($log->feedback)
                                    <div class="mt-2 p-3 bg-gray-50 rounded-md border border-gray-100">
                                        <p class="text-sm text-gray-600 whitespace-pre-wrap">{{ $log->feedback }}</p>
                                    </div>
                                @else
                                    <p class="mt-2 text-sm text-gray-400 italic">Nenhum feedback foi adicionado para esta sessão.</p>
                                @endif
                            </div>
                        @empty
                            <div class="text-center py-10">
                                <p class="text-gray-500">Ainda não há registros de conclusão para este treino.</p>
                            </div>
                        @endforelse
                    </div>

                    {{-- Links de Paginação --}}
                    <div class="mt-8">
                        {{ $logs->links() }}
                    </div>
                </div>
            </div>
        </div>
    </div>
</x-app-layout>