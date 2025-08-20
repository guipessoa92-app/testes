<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            {{ 'Editar Exercício do Treino de ' . $aluno->name }}
        </h2>
    </x-slot>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
                <div class="p-6 text-gray-900">
                    <div class="flex items-center mb-4">
                        <a href="{{ route('personal.students.trainings.show', ['aluno' => $aluno, 'training' => $training]) }}" class="inline-flex items-center px-4 py-2 bg-gray-200 border border-transparent rounded-md font-semibold text-xs text-gray-800 uppercase tracking-widest hover:bg-gray-300 focus:outline-none focus:ring-2 focus:ring-gray-400 focus:ring-offset-2 transition ease-in-out duration-150">
                            <svg class="w-4 h-4 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 19l-7-7m0 0l7-7m-7 7h18"></path></svg>
                            Voltar
                        </a>
                    </div>
                    <h3 class="text-lg font-medium text-gray-900 mb-4">Editar exercício: {{ $exercise->name }}</h3>
                    <form action="{{ route('personal.students.exercises.update', ['aluno' => $aluno, 'training' => $training, 'exercise' => $exercise]) }}" method="POST">
                        @csrf
                        @method('PATCH')
                        <div>
                            <x-input-label for="name" :value="__('Nome do Exercício')" />
                            <x-text-input id="name" class="block mt-1 w-full" type="text" name="name" :value="old('name', $exercise->name)" required autofocus />
                            <x-input-error class="mt-2" :messages="$errors->get('name')" />
                        </div>

                        <div class="mt-4">
                            <x-input-label for="sets" :value="__('Séries')" />
                            <x-text-input id="sets" class="block mt-1 w-full" type="number" name="sets" :value="old('sets', $exercise->sets)" required />
                            <x-input-error class="mt-2" :messages="$errors->get('sets')" />
                        </div>

                        <div class="mt-4">
                            <x-input-label for="reps" :value="__('Repetições')" />
                            <x-text-input id="reps" class="block mt-1 w-full" type="text" name="reps" :value="old('reps', $exercise->reps)" required />
                            <x-input-error class="mt-2" :messages="$errors->get('reps')" />
                        </div>

                        <div class="mt-4">
                            <x-input-label for="load" :value="__('Carga (kg - opcional)')" />
                            <x-text-input id="load" class="block mt-1 w-full" type="number" step="0.01" name="load" :value="old('load', $exercise->load)" />
                            <x-input-error class="mt-2" :messages="$errors->get('load')" />
                        </div>

                        <div class="mt-4">
                            <x-input-label for="rest_time" :value="__('Tempo de Descanso (opcional)')" />
                            <x-text-input id="rest_time" class="block mt-1 w-full" type="text" name="rest_time" :value="old('rest_time', $exercise->rest_time)" />
                            <x-input-error class="mt-2" :messages="$errors->get('rest_time')" />
                        </div>

                        <div class="mt-4">
                            <x-input-label for="notes" :value="__('Observações (opcional)')" />
                            <textarea id="notes" name="notes" rows="3" class="block mt-1 w-full rounded-md shadow-sm border-gray-300 focus:border-indigo-300 focus:ring focus:ring-indigo-200 focus:ring-opacity-50">{{ old('notes', $exercise->notes) }}</textarea>
                            <x-input-error class="mt-2" :messages="$errors->get('notes')" />
                        </div>

                        <div class="flex items-center justify-end mt-4">
                            <x-primary-button>
                                {{ __('Atualizar Exercício') }}
                            </x-primary-button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
</x-app-layout>
