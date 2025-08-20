<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            {{ __('Meus Alunos') }}
        </h2>
    </x-slot>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
                <div class="p-6 text-gray-900">
                    <h3 class="text-2xl font-bold mb-6">Lista de Alunos Vinculados</h3>
                    
                    @if ($alunos->count())
                        <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-6">
                            @foreach ($alunos as $aluno)
                                <div class="p-4 border border-gray-200 rounded-lg shadow-sm hover:shadow-md transition-shadow duration-300">
                                    <h4 class="text-lg font-semibold text-gray-800">{{ $aluno->name }}</h4>
                                    <p class="text-sm text-gray-500 mb-4">{{ $aluno->email }}</p>
                                    
                                    <a href="{{ route('personal.students.trainings', ['aluno' => $aluno->id]) }}" class="inline-block bg-indigo-500 text-white hover:bg-indigo-600 font-bold py-2 px-4 rounded text-sm transition duration-300">
                                        Gerenciar Treinos
                                    </a>
                                </div>
                            @endforeach
                        </div>
                        
                        {{-- Links de Paginação --}}
                        <div class="mt-8">
                            {{ $alunos->links() }}
                        </div>
                    @else
                        <div class="text-center py-10 border-2 border-dashed border-gray-300 rounded-lg">
                            <p class="text-gray-500">Você ainda não tem nenhum aluno vinculado à sua conta.</p>
                            <p class="text-sm text-gray-400 mt-2">Peça para seus alunos se vincularem a você através da página de perfil deles.</p>
                        </div>
                    @endif
                </div>
            </div>
        </div>
    </div>
</x-app-layout>