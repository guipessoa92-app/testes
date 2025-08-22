<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 dark:text-gray-200 leading-tight">
            {{ __('Treino: ') . $training->name }}
        </h2>
    </x-slot>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white dark:bg-gray-800 overflow-hidden shadow-sm sm:rounded-lg">
                <div class="p-6 text-gray-900 dark:text-gray-100">

                    {{-- Bloco de Título e Navegação --}}
                    <div class="flex items-center mb-4">
                        <a href="{{ route('trainings.index') }}" class="inline-flex items-center px-4 py-2 bg-gray-200 dark:bg-gray-600 border border-transparent rounded-md font-semibold text-xs text-gray-800 dark:text-gray-200 uppercase tracking-widest hover:bg-gray-300 dark:hover:bg-gray-500 transition ease-in-out duration-150">
                            <svg class="w-4 h-4 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 19l-7-7m0 0l7-7m-7 7h18"></path></svg>
                            Voltar
                        </a>
                    </div>
                    <div class="mb-4">
                        <h3 class="text-2xl font-bold">{{ $training->name }}</h3>
                        <p class="text-gray-600 dark:text-gray-400">{{ $training->description }}</p>
                    </div>

                    {{-- Lista de Exercícios --}}
                    <div class="mt-8 border-t border-gray-200 dark:border-gray-700 pt-6">
                        <div class="flex justify-between items-center mb-4">
                            <h4 class="text-xl font-semibold">Exercícios</h4>
                            <a href="{{ route('exercises.create', $training) }}" class="inline-flex items-center px-4 py-2 bg-green-500 border border-transparent rounded-md font-semibold text-xs text-white uppercase tracking-widest hover:bg-green-600 active:bg-green-700 focus:outline-none focus:ring-2 focus:ring-green-500 focus:ring-offset-2 dark:focus:ring-offset-gray-800 transition ease-in-out duration-150">
                                <svg class="w-4 h-4 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4v16m8-8H4"></path></svg>
                                Adicionar Exercício
                            </a>
                        </div>
                        
                        {{-- MELHORIA 1: Adicionado feedback visual (toast/mensagem) para o usuário ao reordenar --}}
                        <div x-data="sortableManager()" x-init="initSortable()">
                            <div x-show="successMessage" x-transition:enter="transition ease-out duration-300" x-transition:leave="transition ease-in duration-300" class="mb-4 p-4 bg-green-100 dark:bg-green-900 border border-green-400 text-green-700 dark:text-green-300 rounded-md" x-text="successMessage"></div>
                            
                            <div id="exercise-list" class="space-y-4 mt-4">
                                @forelse ($exercises as $exercise)
                                    <div data-id="{{ $exercise->id }}" class="p-4 bg-gray-100 dark:bg-gray-700 rounded-md shadow-inner flex justify-between items-center handle cursor-grab">
                                        <div>
                                            <h4 class="font-semibold text-lg">{{ $exercise->name }}</h4>
                                            <p class="text-gray-600 dark:text-gray-400">
                                                {{ $exercise->sets }} séries de {{ $exercise->reps }} repetições.
                                                @if ($exercise->load) Carga: {{ $exercise->load }}kg @endif
                                            </p>
                                        </div>
                                        <div class="flex items-center space-x-4">
                                            <a href="{{ route('exercises.edit', ['training' => $training, 'exercise' => $exercise]) }}" class="text-sm text-blue-500 hover:underline">Editar</a>
                                            
                                            {{-- MELHORIA 2: A confirmação de exclusão foi mantida, mas idealmente seria um modal --}}
                                            <form action="{{ route('exercises.destroy', ['training' => $training, 'exercise' => $exercise]) }}" method="POST" onsubmit="return confirm('Tem certeza que deseja excluir este exercício?');">
                                                @csrf
                                                @method('DELETE')
                                                <button type="submit" class="text-sm text-red-500 hover:underline">Excluir</button>
                                            </form>
                                        </div>
                                    </div>
                                @empty
                                    <div class="text-center py-10"><p class="text-gray-600 dark:text-gray-400">Nenhum exercício adicionado ainda.</p></div>
                                @endforelse
                            </div>
                        </div>
                    </div>

                    {{-- Seção de Finalizar Treino --}}
                    <div x-data="{ open: false }" class="mt-8 border-t border-gray-200 dark:border-gray-700 pt-6">
                        {{-- CORREÇÃO PRINCIPAL: Removida a classe 'flex-grow' para corrigir o layout no desktop --}}
                        <div class="flex flex-col space-y-4 md:flex-row md:justify-end md:gap-4 md:space-y-0">
                            <a href="{{ route('dashboard', ['training_completed' => true]) }}" class="inline-flex items-center justify-center px-4 py-2 bg-blue-600 text-white text-xs font-semibold rounded-md hover:bg-blue-700 min-w-max transition">
                                Finalizar Treino
                            </a>
                            <button @click="open = !open" class="inline-flex items-center justify-center px-4 py-2 bg-blue-600 text-white text-xs font-semibold rounded-md hover:bg-blue-700 min-w-max transition">
                                Registrar Sessão
                            </button>
                        </div>
                        <div x-show="open" x-transition class="mt-4 p-4 bg-gray-50 dark:bg-gray-700 rounded-lg">
                            <form action="{{ route('trainings.completeSession', $training) }}" method="POST">
                                @csrf
                                <div>
                                    <label for="feedback" class="block font-medium text-sm text-gray-700 dark:text-gray-300">Feedback (Opcional)</label>
                                    <textarea name="feedback" id="feedback" rows="4" class="mt-1 block w-full border-gray-300 dark:border-gray-700 dark:bg-gray-900 dark:text-gray-300 focus:border-indigo-500 dark:focus:border-indigo-600 focus:ring-indigo-500 dark:focus:ring-indigo-600 rounded-md shadow-sm" placeholder="Como você se sentiu? Alguma dificuldade ou observação?"></textarea>
                                </div>
                                <div class="mt-4">
                                    <button type="submit" class="inline-flex items-center px-4 py-2 bg-blue-600 text-white font-bold rounded-md hover:bg-blue-700 transition">Salvar Treino Finalizado</button>
                                </div>
                            </form>
                        </div>
                    </div>

                </div>
            </div>
        </div>
    </div>
    
    @push('scripts')
    <script src="https://cdn.jsdelivr.net/npm/sortablejs@latest/Sortable.min.js"></script>
    <script>
        function sortableManager() {
            return {
                // MELHORIA 1.1: Adicionamos uma propriedade para controlar a mensagem de sucesso
                successMessage: '',
                initSortable() {
                    const exerciseList = document.getElementById('exercise-list');
                    new Sortable(exerciseList, {
                        animation: 150,
                        handle: '.handle',
                        onEnd: (evt) => { // Usando arrow function para manter o 'this' do Alpine
                            const order = Array.from(evt.to.children).map(el => el.dataset.id);
                            
                            fetch(`{{ route('exercises.reorder', $training) }}`, {
                                method: 'PATCH',
                                headers: {
                                    'Content-Type': 'application/json',
                                    'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').getAttribute('content')
                                },
                                body: JSON.stringify({ order: order })
                            })
                            .then(response => response.json())
                            .then(data => {
                                if (data.success) {
                                    // MELHORIA 1.2: Atualiza a mensagem e a faz desaparecer após alguns segundos
                                    this.successMessage = 'Ordem dos exercícios salva com sucesso!';
                                    setTimeout(() => { this.successMessage = '' }, 3000); // A mensagem some após 3s
                                } else {
                                    alert('Falha ao salvar a ordem.');
                                }
                            })
                            .catch(error => {
                                console.error('Erro:', error);
                                alert('Ocorreu um erro de conexão.');
                            });
                        }
                    });
                }
            }
        }
    </script>
    @endpush
</x-app-layout>