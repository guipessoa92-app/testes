<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 dark:text-gray-200 leading-tight">
            {{ __('Profile') }}
        </h2>
    </x-slot>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8 space-y-6">
            {{-- Formulário de Informações do Perfil --}}
            <div class="p-4 sm:p-8 bg-white dark:bg-gray-800 shadow sm:rounded-lg">
                <div class="max-w-xl">
                    @include('profile.partials.update-profile-information-form')
                </div>
            </div>

            {{-- Formulário de Preferências do Dashboard --}}
            <div class="p-4 sm:p-8 bg-white dark:bg-gray-800 shadow sm:rounded-lg">
                <div class="max-w-xl">
                    <section>
                        <header>
                            <h2 class="text-lg font-medium text-gray-900 dark:text-gray-100">
                                {{ __('Preferências do Dashboard') }}
                            </h2>
                            <p class="mt-1 text-sm text-gray-600 dark:text-gray-400">
                                {{ __("Escolha qual medição você deseja ver em destaque no gráfico do seu painel de controle.") }}
                            </p>
                        </header>
                        <form method="post" action="{{ route('profile.preferences.update') }}" class="mt-6 space-y-6">
                            @csrf
                            @method('patch')
                            <div>
                                <x-input-label for="dashboard_metric" :value="__('Medição em Destaque')" />
                                <x-select-input id="dashboard_metric" name="dashboard_metric" class="mt-1 block w-full">
                                    {{-- As opções agora são geradas dinamicamente --}}
                                    @foreach ($measurementOptions as $key => $details)
                                        <option value="{{ $key }}" {{ Auth::user()->dashboard_metric == $key ? 'selected' : '' }}>
                                            {{ $details['label'] }}
                                        </option>
                                    @endforeach
                                </x-select-input>
                            </div>
                            <div class="flex items-center gap-4">
                                <x-primary-button>{{ __('Salvar Preferência') }}</x-primary-button>
                                @if (session('status') === 'preferences-updated')
                                    <p x-data="{ show: true }" x-show="show" x-transition x-init="setTimeout(() => show = false, 2000)" class="text-sm text-gray-600 dark:text-gray-400">{{ __('Salvo.') }}</p>
                                @endif
                            </div>
                        </form>
                    </section>
                </div>
            </div>

            {{-- Formulário de Senha --}}
            <div class="p-4 sm:p-8 bg-white dark:bg-gray-800 shadow sm:rounded-lg">
                <div class="max-w-xl">
                    @include('profile.partials.update-password-form')
                </div>
            </div>

            {{-- Formulário de Deletar Conta --}}
            <div class="p-4 sm:p-8 bg-white dark:bg-gray-800 shadow sm:rounded-lg">
                <div class="max-w-xl">
                    @include('profile.partials.delete-user-form')
                </div>
            </div>
        </div>
    </div>
</x-app-layout>