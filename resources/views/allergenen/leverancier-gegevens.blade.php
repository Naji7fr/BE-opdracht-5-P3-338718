<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 dark:text-gray-200 leading-tight">
            {{ __('Overzicht leverancier gegevens') }}
        </h2>
    </x-slot>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="mb-4">
                <a href="{{ url()->previous() }}"
                   class="inline-flex items-center px-4 py-2 bg-gray-500 hover:bg-gray-600 text-white rounded-lg transition-colors duration-200">
                    <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5 mr-2" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 19l-7-7m0 0l7-7m-7 7h18" />
                    </svg>
                    Terug naar overzicht
                </a>
            </div>

            <div class="bg-white dark:bg-gray-800 overflow-hidden shadow-sm sm:rounded-lg">
                <div class="p-6 text-gray-900 dark:text-gray-100">
                    <h3 class="text-2xl font-bold mb-6">Overzicht leverancier gegevens</h3>

                    @if($heeftGeenAdres)
                        <div class="mb-6 p-4 bg-amber-100 dark:bg-amber-900/30 border border-amber-300 dark:border-amber-700 rounded-lg text-amber-800 dark:text-amber-200 font-medium">
                            Er zijn geen adresgegevens bekend.
                        </div>
                    @endif

                    <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                        <div>
                            <span class="font-semibold text-gray-700 dark:text-gray-300">Naam leverancier:</span>
                            <span class="ml-2">{{ $leverancier->LeverancierNaam }}</span>
                        </div>
                        <div>
                            <span class="font-semibold text-gray-700 dark:text-gray-300">Contactpersoon:</span>
                            <span class="ml-2">{{ $leverancier->ContactPersoon }}</span>
                        </div>
                        <div>
                            <span class="font-semibold text-gray-700 dark:text-gray-300">Leveranciernummer:</span>
                            <span class="ml-2">{{ $leverancier->LeverancierNummer }}</span>
                        </div>
                        <div>
                            <span class="font-semibold text-gray-700 dark:text-gray-300">Mobiel:</span>
                            <span class="ml-2">{{ $leverancier->Mobiel }}</span>
                        </div>
                        @if(!$heeftGeenAdres)
                            <div>
                                <span class="font-semibold text-gray-700 dark:text-gray-300">Straat:</span>
                                <span class="ml-2">{{ $leverancier->Straat }}</span>
                            </div>
                            <div>
                                <span class="font-semibold text-gray-700 dark:text-gray-300">Huisnummer:</span>
                                <span class="ml-2">{{ $leverancier->Huisnummer }}</span>
                            </div>
                            <div>
                                <span class="font-semibold text-gray-700 dark:text-gray-300">Postcode:</span>
                                <span class="ml-2">{{ $leverancier->Postcode }}</span>
                            </div>
                            <div>
                                <span class="font-semibold text-gray-700 dark:text-gray-300">Stad:</span>
                                <span class="ml-2">{{ $leverancier->Stad }}</span>
                            </div>
                        @endif
                    </div>
                </div>
            </div>
        </div>
    </div>
</x-app-layout>
