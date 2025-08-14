<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            {{ __('Treino: ') . $training->name }}
        </h2>
    </x-slot>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
                <div class="p-6 text-gray-900">
                    {{-- Voltar, Título e Descrição (inalterado) --}}
                    <div class="flex items-center mb-4">
                        <a href="{{ route('trainings.index') }}" class="inline-flex items-center px-4 py-2 bg-gray-200 border border-transparent rounded-md font-semibold text-xs text-gray-800 uppercase tracking-widest hover:bg-gray-300">
                            <svg class="w-4 h-4 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 19l-7-7m0 0l7-7m-7 7h18"></path></svg>
                            Voltar
                        </a>
                    </div>
                    <div class="mb-4">
                        <h3 class="text-2xl font-bold">{{ $training->name }}</h3>
                        <p class="text-gray-600">{{ $training->description }}</p>
                    </div>

                    {{-- Lista de Exercícios (agora mais simples) --}}
                    <div class="mt-8 border-t border-gray-200 pt-6">
                        <div class="flex justify-between items-center mb-4">
                            <h4 class="text-xl font-semibold">Exercícios</h4>
                            <a href="{{ route('exercises.create', $training) }}" class="inline-flex items-center px-4 py-2 bg-green-500 border border-transparent rounded-md font-semibold text-xs text-white uppercase tracking-widest hover:bg-green-600">
                                <svg class="w-4 h-4 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4v16m8-8H4"></path></svg>
                                Adicionar Exercício
                            </a>
                        </div>
                        <div class="space-y-4 mt-4">
                            @forelse ($exercises as $exercise)
                                <div class="p-4 bg-gray-100 rounded-md shadow-inner flex justify-between items-center">
                                    <div>
                                        <h4 class="font-semibold text-lg">{{ $exercise->name }}</h4>
                                        <p class="text-gray-600">
                                            {{ $exercise->sets }} séries de {{ $exercise->reps }} repetições.
                                            @if ($exercise->load) Carga: {{ $exercise->load }}kg @endif
                                        </p>
                                    </div>
                                    <div class="flex items-center">
                                        <a href="{{ route('exercises.edit', ['training' => $training, 'exercise' => $exercise]) }}" class="text-sm text-blue-500 hover:underline mr-4">Editar</a>
                                        <form action="{{ route('exercises.destroy', ['training' => $training, 'exercise' => $exercise]) }}" method="POST" onsubmit="return confirm('Tem certeza?');">
                                            @csrf @method('DELETE')
                                            <button type="submit" class="text-sm text-red-500 hover:underline">Excluir</button>
                                        </form>
                                    </div>
                                </div>
                            @empty
                                <div class="text-center py-10"><p class="text-gray-600">Nenhum exercício adicionado ainda.</p></div>
                            @endforelse
                        </div>
                    </div>

                    <div x-data="{ open: false }" class="mt-8 border-t border-gray-200 pt-6">
                        <div class="flex justify-between items-center">
                            <h4 class="text-xl font-semibold">Finalizar Treino</h4>
                            <div class="space-x-2">
                                <a href="{{ route('trainings.history', $training) }}" class="inline-flex items-center px-4 py-2 bg-gray-500 text-white text-xs font-semibold rounded-md hover:bg-gray-600">Ver Histórico</a>
                                <button @click="open = !open" class="inline-flex items-center px-4 py-2 bg-blue-600 text-white text-xs font-semibold rounded-md hover:bg-blue-700">
                                    Registrar Sessão
                                </button>
                            </div>
                        </div>
                        <div x-show="open" x-transition class="mt-4 p-4 bg-gray-50 rounded-lg">
                            <form action="{{ route('trainings.completeSession', $training) }}" method="POST">
                                @csrf
                                <div>
                                    <label for="feedback" class="block font-medium text-sm text-gray-700">Feedback (Opcional)</label>
                                    <textarea name="feedback" id="feedback" rows="4" class="mt-1 block w-full border-gray-300 rounded-md shadow-sm" placeholder="Como você se sentiu? Alguma dificuldade ou observação?"></textarea>
                                </div>
                                <div class="mt-4">
                                    <button type="submit" class="inline-flex items-center px-4 py-2 bg-blue-600 text-white font-bold rounded-md hover:bg-blue-700">Salvar Treino Finalizado</button>
                                </div>
                            </form>
                        </div>
                    </div>

                </div>
            </div>
        </div>
    </div>
</x-app-layout>