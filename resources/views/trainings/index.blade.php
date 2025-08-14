<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            {{ __('Meus Treinos') }}
        </h2>
    </x-slot>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
                <div class="p-6 text-gray-900">
                    <div class="flex items-center mb-4">
                        {{-- Botão de Voltar --}}
                        <a href="{{ route('dashboard') }}" class="inline-flex items-center px-4 py-2 bg-gray-200 border border-transparent rounded-md font-semibold text-xs text-gray-800 uppercase tracking-widest hover:bg-gray-300 focus:outline-none focus:ring-2 focus:ring-gray-400 focus:ring-offset-2 transition ease-in-out duration-150">
                            <svg class="w-4 h-4 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 19l-7-7m0 0l7-7m-7 7h18"></path></svg>
                            Voltar
                        </a>
                    </div>
                    <div class="flex justify-between items-center mb-4">
                        <h3 class="text-lg font-medium text-gray-900">Lista de Treinos</h3>
                        <a href="{{ route('trainings.create') }}" class="inline-flex items-center px-4 py-2 bg-blue-500 border border-transparent rounded-md font-semibold text-xs text-white uppercase tracking-widest hover:bg-blue-600 focus:outline-none focus:ring-2 focus:ring-blue-500 focus:ring-offset-2 transition ease-in-out duration-150">
                            <svg class="w-4 h-4 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4v16m8-8H4"></path></svg>
                            Novo Treino
                        </a>
                    </div>
                    @if ($trainings->count())
                        <div class="space-y-4">
                            @foreach ($trainings as $training)
                                <div class="p-4 bg-gray-100 rounded-md shadow-inner flex justify-between items-center">
                                    <div>
                                        <h4 class="font-semibold text-lg">
                                            {{ $training->name }}
                                            @if ($training->day_of_week)
                                                <span class="text-sm text-gray-500 ml-2">({{ ucfirst($training->day_of_week) }})</span>
                                            @endif
                                        </h4>
                                        <p class="text-gray-600">{{ $training->description }}</p>
                                    </div>
                                    <div class="flex items-center">
                                        <a href="{{ route('trainings.edit', $training) }}" class="text-sm text-green-500 hover:underline mr-4">Editar</a>
                                        <a href="{{ route('trainings.show', $training) }}" class="text-sm text-blue-500 hover:underline mr-4">Ver Detalhes</a>

                                        <form action="{{ route('trainings.destroy', $training) }}" method="POST" onsubmit="return confirm('Tem certeza que deseja excluir este treino?');">
                                            @csrf
                                            @method('DELETE')
                                            <button type="submit" class="text-sm text-red-500 hover:underline">Excluir</button>
                                        </form>
                                    </div>
                                </div>
                            @endforeach
                        </div>
                    @else
                        <p class="text-gray-600">Nenhum treino cadastrado ainda. Clique em "Novo Treino" para começar!</p>
                    @endif
                </div>
            </div>
        </div>
    </div>
</x-app-layout>