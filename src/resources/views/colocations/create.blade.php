<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            {{ __('Créer une colocation') }}
        </h2>
    </x-slot>

    <div class="py-12">
        <div class="max-w-2xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
                <div class="p-6 text-gray-900 space-y-6">
                    <form method="POST" action="{{ route('colocations.store') }}" class="space-y-4">
                        @csrf

                        <div>
                            <x-input-label for="name" value="Nom" />
                            <x-text-input id="name" name="name" type="text" class="mt-1 block w-full" required autofocus
                                value="{{ old('name') }}" />
                            <x-input-error class="mt-2" :messages="$errors->get('name')" />
                        </div>

                        <x-primary-button>Créer</x-primary-button>
                        <a href="{{ route('colocations.index') }}" class="ml-3 text-sm text-gray-600 underline">Annuler</a>
                    </form>
                </div>
            </div>
        </div>
    </div>
</x-app-layout>

