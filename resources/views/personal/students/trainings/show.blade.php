<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            {{ 'Treino de ' . $aluno->name . ': ' . $training->name }}
        </h2>
    </x-slot>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
                <div class="p-6 text-gray-900">
                    {{-- Voltar, Título e Descrição --}}
                    <div class="flex items-center mb-4">
                        <a href="{{ route('personal.students.trainings', $aluno) }}" class="inline-flex items-center px-4 py-2 bg-gray-200 border border-transparent rounded-md font-semibold text-xs text-gray-800 uppercase tracking-widest hover:bg-gray-300">
                            <svg class="w-4 h-4 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 19l-7-7m0 0l7-7m-7 7h18"></path></svg>
                            Voltar
                        </a>
                    </div>
                    <div class="mb-4">
                        <h3 class="text-2xl font-bold">{{ $training->name }}</h3>
                        <p class="text-gray-600">{{ $training->description }}</p>
                    </div>

                    {{-- Lista de Exercícios --}}
                    <div class="mt-8 border-t border-gray-200 pt-6">
                        <div class="flex justify-between items-center mb-4">
                            <h4 class="text-xl font-semibold">Exercícios</h4>
                            <a href="{{ route('personal.students.exercises.create', ['aluno' => $aluno, 'training' => $training]) }}" class="inline-flex items-center px-4 py-2 bg-green-500 border border-transparent rounded-md font-semibold text-xs text-white uppercase tracking-widest hover:bg-green-600">
                                <svg class="w-4 h-4 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4v16m8-8H4"></path></svg>
                                Adicionar Exercício
                            </a>
                        </div>
                        
                        <div class="space-y-4 mt-4">
                            @forelse ($training->exercises as $exercise)
                                <div class="p-4 bg-gray-100 rounded-md shadow-inner flex justify-between items-center">
                                    <div>
                                        <h4 class="font-semibold text-lg">{{ $exercise->name }}</h4>
                                        <p class="text-gray-600">
                                            {{ $exercise->sets }} séries de {{ $exercise->repetitions }} repetições.
                                            @if ($exercise->weight) Carga: {{ $exercise->weight }}kg @endif
                                        </p>
                                    </div>
                                    <div class="flex items-center">
                                        <a href="{{ route('personal.students.exercises.edit', ['aluno' => $aluno, 'training' => $training, 'exercise' => $exercise]) }}" class="text-sm text-blue-500 hover:underline mr-4">Editar</a>
                                        <form action="{{ route('personal.students.exercises.destroy', ['aluno' => $aluno, 'training' => $training, 'exercise' => $exercise]) }}" method="POST" onsubmit="return confirm('Tem certeza?');">
                                            @csrf
                                            @method('DELETE')
                                            <button type="submit" class="text-sm text-red-500 hover:underline">Excluir</button>
                                        </form>
                                    </div>
                                </div>
                            @empty
                                <div class="text-center py-10"><p class="text-gray-600">Nenhum exercício adicionado ainda.</p></div>
                            @endforelse
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</x-app-layout>
