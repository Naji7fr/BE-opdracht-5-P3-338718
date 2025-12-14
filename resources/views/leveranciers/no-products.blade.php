<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            {{ __('Geleverde Producten') }}
        </h2>
    </x-slot>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
                <div class="p-6 text-gray-900">
                    <div class="text-center py-12">
                        <h3 class="text-2xl font-bold text-gray-800 mb-2">Geen Producten</h3>
                        <p class="text-xl text-red-600 mb-4">
                            Dit bedrijf heeft tot nu toe geen producten geleverd aan Jamin
                        </p>
                        <p class="text-gray-500 mb-6">
                            U wordt over 3 seconden doorgestuurd naar het overzicht...
                        </p>
                        
                        <div class="inline-flex items-center space-x-2">
                            <div class="animate-spin rounded-full h-5 w-5 border-b-2 border-blue-600"></div>
                            <span class="text-gray-600">Doorsturen...</span>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <script>
        // Redirect after 3 seconds
        setTimeout(function() {
            window.location.href = "{{ route('leveranciers.index') }}";
        }, 3000);
    </script>
</x-app-layout>
