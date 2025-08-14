<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            {{ __('Editar Medida') }}
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
                    <h3 class="text-lg font-medium text-gray-900 mb-4">Editar Medidas de {{ \Carbon\Carbon::parse($measurement->measurement_date)->format('d/m/Y') }}</h3>
                    <form action="{{ route('measurements.update', $measurement) }}" method="POST">
                        @csrf
                        @method('PATCH')

                        @if ($errors->any())
                            <div class="mb-4 bg-red-100 border border-red-400 text-red-700 px-4 py-3 rounded relative" role="alert">
                                <strong class="font-bold">Opa!</strong>
                                <span class="block sm:inline">Houve alguns problemas com os dados que você inseriu.</span>
                                <ul class="mt-3 list-disc list-inside text-sm">
                                    @foreach ($errors->all() as $error)
                                        <li>{{ $error }}</li>
                                    @endforeach
                                </ul>
                            </div>
                        @endif

                        <!-- Medidas Principais -->
                        <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                            <div>
                                <x-input-label for="measurement_date" :value="__('Data da Medição')" />
                                <x-text-input id="measurement_date" class="block mt-1 w-full" type="date" name="measurement_date" :value="old('measurement_date', $measurement->measurement_date->format('Y-m-d'))" required autofocus />
                                <x-input-error class="mt-2" :messages="$errors->get('measurement_date')" />
                            </div>
                            <div>
                                <x-input-label for="weight" :value="__('Peso (kg)')" />
                                <x-text-input id="weight" class="block mt-1 w-full" type="number" step="0.01" name="weight" :value="old('weight', $measurement->weight)" max="999.99" />
                                <x-input-error class="mt-2" :messages="$errors->get('weight')" />
                            </div>
                        </div>

                        <!-- Medidas de Circunferência -->
                        <div class="mt-4">
                            <h4 class="text-lg font-semibold mb-2">Medidas de Circunferência (cm)</h4>
                            <div class="grid grid-cols-1 md:grid-cols-3 gap-4">
                                <div>
                                    <x-input-label for="shoulders" :value="__('Ombros')" />
                                    <x-text-input id="shoulders" class="block mt-1 w-full" type="number" step="0.01" name="shoulders" :value="old('shoulders', $measurement->shoulders)" max="999.99" />
                                </div>
                                <div>
                                    <x-input-label for="chest" :value="__('Peito')" />
                                    <x-text-input id="chest" class="block mt-1 w-full" type="number" step="0.01" name="chest" :value="old('chest', $measurement->chest)" max="999.99" />
                                </div>
                                <div>
                                    <x-input-label for="waist" :value="__('Cintura')" />
                                    <x-text-input id="waist" class="block mt-1 w-full" type="number" step="0.01" name="waist" :value="old('waist', $measurement->waist)" max="999.99" />
                                </div>
                                <div>
                                    <x-input-label for="abdomen" :value="__('Abdômen')" />
                                    <x-text-input id="abdomen" class="block mt-1 w-full" type="number" step="0.01" name="abdomen" :value="old('abdomen', $measurement->abdomen)" max="999.99" />
                                </div>
                                <div>
                                    <x-input-label for="hips" :value="__('Quadril')" />
                                    <x-text-input id="hips" class="block mt-1 w-full" type="number" step="0.01" name="hips" :value="old('hips', $measurement->hips)" max="999.99" />
                                </div>
                                <div>
                                    <x-input-label for="gluteos" :value="__('Glúteos')" />
                                    <x-text-input id="gluteos" class="block mt-1 w-full" type="number" step="0.01" name="gluteos" :value="old('gluteos', $measurement->gluteos)" max="999.99" />
                                </div>
                            </div>
                        </div>

                        <!-- Membros Superiores -->
                        <div class="mt-4">
                            <h4 class="text-lg font-semibold mb-2">Membros Superiores (cm)</h4>
                            <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                                <fieldset class="border p-4 rounded-md">
                                    <legend class="font-medium">Bíceps Direito</legend>
                                    <div class="grid grid-cols-1 md:grid-cols-2 gap-4 mt-2">
                                        <div>
                                            <x-input-label for="biceps_right_contracted" :value="__('Contraído')" />
                                            <x-text-input id="biceps_right_contracted" class="block mt-1 w-full" type="number" step="0.01" name="biceps_right_contracted" :value="old('biceps_right_contracted', $measurement->biceps_right_contracted)" max="999.99" />
                                        </div>
                                        <div>
                                            <x-input-label for="biceps_right_relaxed" :value="__('Relaxado')" />
                                            <x-text-input id="biceps_right_relaxed" class="block mt-1 w-full" type="number" step="0.01" name="biceps_right_relaxed" :value="old('biceps_right_relaxed', $measurement->biceps_right_relaxed)" max="999.99" />
                                        </div>
                                    </div>
                                </fieldset>
                                <fieldset class="border p-4 rounded-md">
                                    <legend class="font-medium">Bíceps Esquerdo</legend>
                                    <div class="grid grid-cols-1 md:grid-cols-2 gap-4 mt-2">
                                        <div>
                                            <x-input-label for="biceps_left_contracted" :value="__('Contraído')" />
                                            <x-text-input id="biceps_left_contracted" class="block mt-1 w-full" type="number" step="0.01" name="biceps_left_contracted" :value="old('biceps_left_contracted', $measurement->biceps_left_contracted)" max="999.99" />
                                        </div>
                                        <div>
                                            <x-input-label for="biceps_left_relaxed" :value="__('Relaxado')" />
                                            <x-text-input id="biceps_left_relaxed" class="block mt-1 w-full" type="number" step="0.01" name="biceps_left_relaxed" :value="old('biceps_left_relaxed', $measurement->biceps_left_relaxed)" max="999.99" />
                                        </div>
                                    </div>
                                </fieldset>
                                <fieldset class="border p-4 rounded-md">
                                    <legend class="font-medium">Antebraço</legend>
                                    <div class="grid grid-cols-1 md:grid-cols-2 gap-4 mt-2">
                                        <div>
                                            <x-input-label for="forearm_right" :value="__('Direito')" />
                                            <x-text-input id="forearm_right" class="block mt-1 w-full" type="number" step="0.01" name="forearm_right" :value="old('forearm_right', $measurement->forearm_right)" max="999.99" />
                                        </div>
                                        <div>
                                            <x-input-label for="forearm_left" :value="__('Esquerdo')" />
                                            <x-text-input id="forearm_left" class="block mt-1 w-full" type="number" step="0.01" name="forearm_left" :value="old('forearm_left', $measurement->forearm_left)" max="999.99" />
                                        </div>
                                    </div>
                                </fieldset>
                            </div>
                        </div>

                        <!-- Membros Inferiores -->
                        <div class="mt-4">
                            <h4 class="text-lg font-semibold mb-2">Membros Inferiores (cm)</h4>
                            <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                                <fieldset class="border p-4 rounded-md">
                                    <legend class="font-medium">Coxa</legend>
                                    <div class="grid grid-cols-1 md:grid-cols-2 gap-4 mt-2">
                                        <div>
                                            <x-input-label for="thigh_right" :value="__('Direita')" />
                                            <x-text-input id="thigh_right" class="block mt-1 w-full" type="number" step="0.01" name="thigh_right" :value="old('thigh_right', $measurement->thigh_right)" max="999.99" />
                                        </div>
                                        <div>
                                            <x-input-label for="thigh_left" :value="__('Esquerda')" />
                                            <x-text-input id="thigh_left" class="block mt-1 w-full" type="number" step="0.01" name="thigh_left" :value="old('thigh_left', $measurement->thigh_left)" max="999.99" />
                                        </div>
                                    </div>
                                </fieldset>
                                <fieldset class="border p-4 rounded-md">
                                    <legend class="font-medium">Panturrilha</legend>
                                    <div class="grid grid-cols-1 md:grid-cols-2 gap-4 mt-2">
                                        <div>
                                            <x-input-label for="calf_right" :value="__('Direita')" />
                                            <x-text-input id="calf_right" class="block mt-1 w-full" type="number" step="0.01" name="calf_right" :value="old('calf_right', $measurement->calf_right)" max="999.99" />
                                        </div>
                                        <div>
                                            <x-input-label for="calf_left" :value="__('Esquerda')" />
                                            <x-text-input id="calf_left" class="block mt-1 w-full" type="number" step="0.01" name="calf_left" :value="old('calf_left', $measurement->calf_left)" max="999.99" />
                                        </div>
                                    </div>
                                </fieldset>
                            </div>
                        </div>

                        <!-- Seção Oculta para Adipômetro -->
                        <div class="mt-8 border-t border-gray-200 pt-6" x-data="{ open: false }">
                            <h4 class="text-xl font-semibold mb-4 cursor-pointer flex items-center" @click="open = ! open">
                                Percentual de Gordura Corporal (Adipômetro)
                                <svg x-bind:class="{ 'rotate-180': open }" class="w-5 h-5 ml-2 transition-transform duration-300 transform" fill="none" stroke="currentColor" viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 9l-7 7-7-7"></path></svg>
                            </h4>
                            <div x-show="open" x-collapse>
                                <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                                    <div>
                                        <x-input-label for="age" :value="__('Idade')" />
                                        <x-text-input id="age" class="block mt-1 w-full" type="number" name="age" :value="old('age', $measurement->age)" max="200" />
                                        <x-input-error class="mt-2" :messages="$errors->get('age')" />
                                    </div>
                                    <div>
                                        <x-input-label for="sex" :value="__('Sexo')" />
                                        <select id="sex" name="sex" class="block mt-1 w-full rounded-md shadow-sm border-gray-300 focus:border-indigo-300 focus:ring focus:ring-indigo-200 focus:ring-opacity-50">
                                            <option value="">Selecione</option>
                                            <option value="male" {{ old('sex', $measurement->sex) == 'male' ? 'selected' : '' }}>Masculino</option>
                                            <option value="female" {{ old('sex', $measurement->sex) == 'female' ? 'selected' : '' }}>Feminino</option>
                                        </select>
                                        <x-input-error class="mt-2" :messages="$errors->get('sex')" />
                                    </div>
                                    <div>
                                        <x-input-label for="pectorals" :value="__('Peitoral (mm)')" />
                                        <x-text-input id="pectorals" class="block mt-1 w-full" type="number" step="0.01" name="pectorals" :value="old('pectorals', $measurement->pectorals)" max="999.99" />
                                        <x-input-error class="mt-2" :messages="$errors->get('pectorals')" />
                                    </div>
                                    <div>
                                        <x-input-label for="midaxillary" :value="__('Axilar Média (mm)')" />
                                        <x-text-input id="midaxillary" class="block mt-1 w-full" type="number" step="0.01" name="midaxillary" :value="old('midaxillary', $measurement->midaxillary)" max="999.99" />
                                        <x-input-error class="mt-2" :messages="$errors->get('midaxillary')" />
                                    </div>
                                    <div>
                                        <x-input-label for="triceps" :value="__('Tricipital (mm)')" />
                                        <x-text-input id="triceps" class="block mt-1 w-full" type="number" step="0.01" name="triceps" :value="old('triceps', $measurement->triceps)" max="999.99" />
                                        <x-input-error class="mt-2" :messages="$errors->get('triceps')" />
                                    </div>
                                    <div>
                                        <x-input-label for="subscapular" :value="__('Subescapular (mm)')" />
                                        <x-text-input id="subscapular" class="block mt-1 w-full" type="number" step="0.01" name="subscapular" :value="old('subscapular', $measurement->subscapular)" max="999.99" />
                                        <x-input-error class="mt-2" :messages="$errors->get('subscapular')" />
                                    </div>
                                    <div>
                                        <x-input-label for="abdominal" :value="__('Abdominal (mm)')" />
                                        <x-text-input id="abdominal" class="block mt-1 w-full" type="number" step="0.01" name="abdominal" :value="old('abdominal', $measurement->abdominal)" max="999.99" />
                                        <x-input-error class="mt-2" :messages="$errors->get('abdominal')" />
                                    </div>
                                    <div>
                                        <x-input-label for="suprailiac" :value="__('Supra-ilíaca (mm)')" />
                                        <x-text-input id="suprailiac" class="block mt-1 w-full" type="number" step="0.01" name="suprailiac" :value="old('suprailiac', $measurement->suprailiac)" max="999.99" />
                                        <x-input-error class="mt-2" :messages="$errors->get('suprailiac')" />
                                    </div>
                                    <div>
                                        <x-input-label for="skinfold_thigh_right" :value="__('Coxa Direita (mm)')" />
                                        <x-text-input id="skinfold_thigh_right" class="block mt-1 w-full" type="number" step="0.01" name="skinfold_thigh_right" :value="old('skinfold_thigh_right', $measurement->skinfold_thigh_right)" max="999.99" />
                                        <x-input-error class="mt-2" :messages="$errors->get('skinfold_thigh_right')" />
                                    </div>
                                    <div>
                                        <x-input-label for="skinfold_thigh_left" :value="__('Coxa Esquerda (mm)')" />
                                        <x-text-input id="skinfold_thigh_left" class="block mt-1 w-full" type="number" step="0.01" name="skinfold_thigh_left" :value="old('skinfold_thigh_left', $measurement->skinfold_thigh_left)" max="999.99" />
                                        <x-input-error class="mt-2" :messages="$errors->get('skinfold_thigh_left')" />
                                    </div>
                                </div>
                            </div>
                        </div>

                        <div class="mt-4">
                            <x-input-label for="notes" :value="__('Observações (opcional)')" />
                            <textarea id="notes" name="notes" rows="3" class="block mt-1 w-full rounded-md shadow-sm border-gray-300 focus:border-indigo-300 focus:ring focus:ring-indigo-200 focus:ring-opacity-50">{{ old('notes', $measurement->notes) }}</textarea>
                            <x-input-error class="mt-2" :messages="$errors->get('notes')" />
                        </div>

                        <div class="flex items-center justify-end mt-4">
                            <x-primary-button>
                                {{ __('Salvar Alterações') }}
                            </x-primary-button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
    <script>
        document.addEventListener('DOMContentLoaded', function () {
            // Handle decimal measurement inputs
            const measurementInputs = document.querySelectorAll('input[type="number"][step="0.01"]');
            measurementInputs.forEach(input => {
                input.addEventListener('input', function (e) {
                    const [integerPart, decimalPart] = e.target.value.split('.');
                    if (integerPart.length > 3) {
                        e.target.value = integerPart.slice(0, 3) + (decimalPart !== undefined ? '.' + decimalPart : '');
                    }
                });
            });

            // Handle age input
            const ageInput = document.querySelector('input[name="age"]');
            if (ageInput) {
                ageInput.addEventListener('input', function (e) {
                    if (e.target.value.length > 3) {
                        e.target.value = e.target.value.slice(0, 3);
                    }
                    if (parseInt(e.target.value, 10) > 200) {
                        e.target.value = 200;
                    }
                });
            }
        });
    </script>
</x-app-layout>