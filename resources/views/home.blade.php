<x-home-layout>

    <div class="bg-white">
        <nav x-data="{ isOpen: false }" class="bg-white text-gray-800 shadow-sm relative">
            <div class="container mx-auto max-w-7xl px-6">
                <div class="flex justify-between items-center h-20">
                    <div class="flex-shrink-0">
                        <a href="{{ route('home') }}" class="text-2xl font-bold tracking-wider text-gray-900">
                            FitApp
                        </a>
                    </div>

                    <div class="hidden md:flex items-center space-x-8">
                        <a href="#" class="text-gray-600 hover:text-indigo-600 transition-colors">Funcionalidades</a>
                        <a href="#" class="text-gray-600 hover:text-indigo-600 transition-colors">Preços</a>
                        <a href="#" class="text-gray-600 hover:text-indigo-600 transition-colors">Sobre</a>
                    </div>

                    <div class="hidden md:block">
                        <a href="{{ route('login') }}" class="border border-gray-300 hover:bg-gray-100 text-gray-800 font-bold py-2 px-5 rounded-md transition-colors">
                            Acessar
                        </a>
                    </div>

                    <div class="md:hidden">
                        <button @click="isOpen = !isOpen" class="text-gray-800 hover:text-indigo-600 focus:outline-none">
                            <svg class="w-8 h-8" fill="none" stroke="currentColor" viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg">
                                <path x-show="!isOpen" stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 6h16M4 12h16m-7 6h7"></path>
                                <path x-show="isOpen" stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"></path>
                            </svg>
                        </button>
                    </div>
                </div>
            </div>

            <div
                x-show="isOpen"
                x-transition
                @click.away="isOpen = false"
                class="md:hidden absolute w-full bg-white shadow-lg py-4"
            >
                <a href="#" class="block px-6 py-2 text-gray-600 hover:bg-gray-100">Funcionalidades</a>
                <a href="#" class="block px-6 py-2 text-gray-600 hover:bg-gray-100">Preços</a>
                <a href="#" class="block px-6 py-2 text-gray-600 hover:bg-gray-100">Sobre</a>
                <div class="px-6 py-4">
                    <a href="{{ route('login') }}" class="block text-center w-full bg-indigo-600 hover:bg-indigo-700 text-white font-bold py-3 px-5 rounded-md transition-colors">
                        Acessar
                    </a>
                </div>
            </div>
        </nav>

        <main>
            <div class="relative bg-gray-50 text-gray-800">
                <div class="container mx-auto max-w-7xl px-6 py-28 md:py-40 text-center">
                    <h1 class="text-4xl md:text-6xl font-extrabold leading-tight tracking-tighter text-gray-900">
                        Treinos sob medida para você.
                    </h1>
                    <p class="mt-6 text-lg md:text-xl text-gray-600 max-w-3xl mx-auto">
                        Acompanhe seu progresso, registre suas medidas e organize seus treinos. Sua evolução começa agora.
                    </p>
                    
                    <div class="mt-12 flex flex-col items-center space-y-4">
                        <a href="{{ route('register') }}" class="bg-red-600 hover:bg-red-700 text-white font-bold py-4 px-10 rounded-lg text-xl uppercase tracking-wider transition-transform transform hover:scale-105">
                            Comece Agora
                        </a>
                        <a href="{{ route('login') }}" class="bg-red-600 hover:bg-red-700 text-white font-bold py-4 px-10 rounded-lg text-xl uppercase tracking-wider transition-transform transform hover:scale-105">
                            Login
                        </a>
                    </div>
                </div>
            </div>

            <div class="bg-white py-16 md:py-24 border-t border-gray-200">
                <div class="container mx-auto max-w-7xl px-6">
                    <div class="grid grid-cols-1 md:grid-cols-3 gap-10 text-center">
                        
                        <div class="p-8">
                            <h3 class="text-2xl font-bold text-gray-800 mb-2">Medidas</h3>
                            <p class="text-gray-500">Registre e visualize o histórico completo das suas medidas corporais.</p>
                        </div>

                        <div class="p-8">
                            <h3 class="text-2xl font-bold text-gray-800 mb-2">Treinos</h3>
                            <p class="text-gray-500">Crie, organize e acesse suas fichas de treino a qualquer momento.</p>
                        </div>

                        <div class="p-8">
                            <h3 class="text-2xl font-bold text-gray-800 mb-2">Progresso</h3>
                            <p class="text-gray-500">Analise sua performance através de gráficos detalhados e intuitivos.</p>
                        </div>
                    </div>
                </div>
            </div>
        </main>
    </div>

</x-home-layout>