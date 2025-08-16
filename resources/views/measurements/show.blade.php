<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            {{ __('Detalhes da Medida') }}
        </h2>
    </x-slot>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
                <div class="p-6 text-gray-900">
                    <div class="flex items-center mb-4">
                        <a href="{{ route('measurements.index') }}" class="inline-flex items-center px-4 py-2 bg-gray-200 border border-transparent rounded-md font-semibold text-xs text-gray-800 uppercase tracking-widest hover:bg-gray-300 focus:outline-none focus:ring-2 focus:ring-gray-400 focus:ring-offset-2 transition ease-in-out duration-150">
                            <svg class="w-4 h-4 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 19l-7-7m0 0l7-7m-7 7h18"></path></svg>
                            Voltar
                        </a>
                        
                    </div>

                    <h3 class="text-xl font-bold mb-4">Medição em {{ \Carbon\Carbon::parse($measurement->measurement_date)->format('d/m/Y') }}</h3>

                    <!-- Medidas Principais -->
                    <div class="mt-4">
                        <h4 class="text-lg font-semibold mb-2">Medidas Principais</h4>
                        <div class="grid grid-cols-1 md:grid-cols-3 gap-4">
                            <div class="bg-gray-100 p-4 rounded-md">
                                <p class="font-bold">Peso:</p>
                                <p>{{ $measurement->weight }} kg</p>
                            </div>
                            
                            <div class="bg-gray-100 p-4 rounded-md">
                                <p class="font-bold">Sexo:</p>
                                <p>{{ $measurement->sex == 'male' ? 'Masculino' : 'Feminino' }}</p>
                            </div>
                        </div>
                    </div>

                    <!-- Medidas de Circunferência -->
                    <div class="mt-4">
                        <h4 class="text-lg font-semibold mb-2">Medidas de Circunferência</h4>
                        <div class="grid grid-cols-1 md:grid-cols-3 gap-4">
                            <div class="bg-gray-100 p-4 rounded-md">
                                <p class="font-bold">Ombros:</p>
                                <p>{{ $measurement->shoulders }} cm</p>
                            </div>
                            <div class="bg-gray-100 p-4 rounded-md">
                                <p class="font-bold">Peito:</p>
                                <p>{{ $measurement->chest }} cm</p>
                            </div>
                            <div class="bg-gray-100 p-4 rounded-md">
                                <p class="font-bold">Cintura:</p>
                                <p>{{ $measurement->waist }} cm</p>
                            </div>
                            <div class="bg-gray-100 p-4 rounded-md">
                                <p class="font-bold">Abdômen:</p>
                                <p>{{ $measurement->abdomen }} cm</p>
                            </div>
                            <div class="bg-gray-100 p-4 rounded-md">
                                <p class="font-bold">Quadril:</p>
                                <p>{{ $measurement->hips }} cm</p>
                            </div>
                            <div class="bg-gray-100 p-4 rounded-md">
                                <p class="font-bold">Glúteos:</p>
                                <p>{{ $measurement->gluteos }} cm</p>
                            </div>
                        </div>
                    </div>

                    <!-- Membros Superiores -->
                    <div class="mt-4">
                        <h4 class="text-lg font-semibold mb-2">Membros Superiores</h4>
                        <div class="grid grid-cols-1 md:grid-cols-4 gap-4">
                            <div class="bg-gray-100 p-4 rounded-md">
                                <p class="font-bold">Bíceps Direito Contraído:</p>
                                <p>{{ $measurement->biceps_right_contracted }} cm</p>
                            </div>
                            <div class="bg-gray-100 p-4 rounded-md">
                                <p class="font-bold">Bíceps Direito Relaxado:</p>
                                <p>{{ $measurement->biceps_right_relaxed }} cm</p>
                            </div>
                            <div class="bg-gray-100 p-4 rounded-md">
                                <p class="font-bold">Bíceps Esquerdo Contraído:</p>
                                <p>{{ $measurement->biceps_left_contracted }} cm</p>
                            </div>
                            <div class="bg-gray-100 p-4 rounded-md">
                                <p class="font-bold">Bíceps Esquerdo Relaxado:</p>
                                <p>{{ $measurement->biceps_left_relaxed }} cm</p>
                            </div>
                            <div class="bg-gray-100 p-4 rounded-md">
                                <p class="font-bold">Antebraço Direito:</p>
                                <p>{{ $measurement->forearm_right }} cm</p>
                            </div>
                            <div class="bg-gray-100 p-4 rounded-md">
                                <p class="font-bold">Antebraço Esquerdo:</p>
                                <p>{{ $measurement->forearm_left }} cm</p>
                            </div>
                        </div>
                    </div>

                    <!-- Membros Inferiores -->
                    <div class="mt-4">
                        <h4 class="text-lg font-semibold mb-2">Membros Inferiores</h4>
                        <div class="grid grid-cols-1 md:grid-cols-4 gap-4">
                            <div class="bg-gray-100 p-4 rounded-md">
                                <p class="font-bold">Coxa Direita:</p>
                                <p>{{ $measurement->thigh_right }} cm</p>
                            </div>
                            <div class="bg-gray-100 p-4 rounded-md">
                                <p class="font-bold">Coxa Esquerda:</p>
                                <p>{{ $measurement->thigh_left }} cm</p>
                            </div>
                            <div class="bg-gray-100 p-4 rounded-md">
                                <p class="font-bold">Panturrilha Direita:</p>
                                <p>{{ $measurement->calf_right }} cm</p>
                            </div>
                            <div class="bg-gray-100 p-4 rounded-md">
                                <p class="font-bold">Panturrilha Esquerda:</p>
                                <p>{{ $measurement->calf_left }} cm</p>
                            </div>
                        </div>
                    </div>

                    <!-- Dobras Cutâneas (Adipômetro) -->
                    <div class="mt-4 border-t border-gray-200 pt-4">
                        <h4 class="text-xl font-semibold mb-2">Percentual de Gordura Corporal (Adipômetro)</h4>
                        <div class="mt-2 grid grid-cols-1 md:grid-cols-3 gap-4">
                            <div class="bg-gray-100 p-4 rounded-md">
                                <p class="font-bold">Peitoral:</p>
                                <p>{{ $measurement->pectorals }} mm</p>
                            </div>
                            <div class="bg-gray-100 p-4 rounded-md">
                                <p class="font-bold">Axilar Média:</p>
                                <p>{{ $measurement->midaxillary }} mm</p>
                            </div>
                            <div class="bg-gray-100 p-4 rounded-md">
                                <p class="font-bold">Tricipital:</p>
                                <p>{{ $measurement->triceps }} mm</p>
                            </div>
                            <div class="bg-gray-100 p-4 rounded-md">
                                <p class="font-bold">Subescapular:</p>
                                <p>{{ $measurement->subscapular }} mm</p>
                            </div>
                            <div class="bg-gray-100 p-4 rounded-md">
                                <p class="font-bold">Abdominal:</p>
                                <p>{{ $measurement->abdominal }} mm</p>
                            </div>
                            <div class="bg-gray-100 p-4 rounded-md">
                                <p class="font-bold">Supra-ilíaca:</p>
                                <p>{{ $measurement->suprailiac }} mm</p>
                            </div>
                            <div class="bg-gray-100 p-4 rounded-md">
                                <p class="font-bold">Coxa Direita:</p>
                                <p>{{ $measurement->skinfold_thigh_right }} mm</p>
                            </div>
                            <div class="bg-gray-100 p-4 rounded-md">
                                <p class="font-bold">Coxa Esquerda:</p>
                                <p>{{ $measurement->skinfold_thigh_left }} mm</p>
                            </div>
                        </div>
                    </div>

                    @if($measurement->notes)
                        <div class="mt-4 bg-gray-100 p-4 rounded-md">
                            <p class="font-bold">Observações:</p>
                            <p>{{ $measurement->notes }}</p>
                        </div>
                    @endif

                </div>
            </div>
        </div>
    </div>
</x-app-layout>