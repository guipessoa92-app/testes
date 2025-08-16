<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            {{ __('Histórico de Feedbacks') }}
        </h2>
    </x-slot>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
                <div class="p-6 text-gray-900">
                    <div class="space-y-6">
                        @forelse ($feedbacks as $log)
                            <div class="p-4 border border-gray-200 rounded-lg">
                                <div class="flex justify-between items-center">
                                    <p class="font-bold text-lg text-indigo-600">{{ $log->training->name }}</p>
                                    <p class="text-sm text-gray-500">
                                        {{ $log->completed_at->format('d/m/Y \à\s H:i') }}
                                    </p>
                                </div>
                                <div class="mt-3 p-3 bg-gray-50 rounded-md border border-gray-100">
                                    <p class="text-sm text-gray-700 whitespace-pre-wrap">{{ $log->feedback }}</p>
                                </div>
                            </div>
                        @empty
                            <div class="text-center py-10">
                                <p class="text-gray-500">Ainda não há feedbacks registrados.</p>
                            </div>
                        @endforelse
                    </div>

                    {{-- Links de Paginação --}}
                    <div class="mt-8">
                        {{ $feedbacks->links() }}
                    </div>
                </div>
            </div>
        </div>
    </div>
</x-app-layout>