<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            {{ __('Gerenciando Treinos de: ') . $aluno->name }}
        </h2>
    </x-slot>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
                <div class="p-6 text-gray-900">
                    <div class="flex items-center mb-4">
                        <a href="{{ route('personal.students.index') }}" class="inline-flex items-center px-4 py-2 bg-gray-200 border border-transparent rounded-md font-semibold text-xs text-gray-800 uppercase tracking-widest hover:bg-gray-300">
                            <svg class="w-4 h-4 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 19l-7-7m0 0l7-7m-7 7h18"></path></svg>
                            Voltar para Alunos
                        </a>
                    </div>

                    <div class="flex justify-between items-center mb-6">
                        <h3 class="text-2xl font-bold">Fichas de Treino</h3>
                        {{-- BOTÃO ATUALIZADO PARA A NOVA ROTA --}}
                        <a href="{{ route('personal.students.trainings.create', $aluno) }}" class="inline-flex items-center px-4 py-2 bg-green-500 text-white text-xs font-semibold rounded-md hover:bg-green-600">
                            <svg class="w-4 h-4 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4v16m8-8H4"></path></svg>
                            Criar Novo Treino
                        </a>
                    </div>

                    @if ($trainings->count())
                        <div class="space-y-4">
                            @foreach ($trainings as $training)
                                <div class="p-4 border border-gray-200 rounded-lg flex justify-between items-center">
                                    <div>
                                        <h4 class="text-lg font-semibold text-gray-800">{{ $training->name }}</h4>
                                        <p class="text-sm text-gray-500">
                                            Dias: 
                                            @forelse($training->daysOfWeek as $day)
                                                {{ ucfirst($day->name) }}{{ !$loop->last ? ',' : '' }}
                                            @empty
                                                Nenhum dia definido
                                            @endforelse
                                        </p>
                                    </div>
                                    <div class="flex items-center space-x-4 text-sm">
                                        <a href="{{ route('personal.students.trainings.show', ['aluno' => $aluno, 'training' => $training]) }}" class="text-indigo-600 hover:underline">Visualizar Detalhes</a>
                                    </div>
                                </div>
                            @endforeach
                        </div>
                    @else
                        <div class="text-center py-10 border-2 border-dashed border-gray-300 rounded-lg">
                            <p class="text-gray-500">{{ $aluno->name }} ainda não possui treinos.</p>
                        </div>
                    @endif
                </div>
            </div>
        </div>
    </div>
</x-app-layout>