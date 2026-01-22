<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            {{ __('Leverancier Details') }}
        </h2>
    </x-slot>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <!-- Success/Error Messages -->
            @if(session('success'))
                <div class="mb-4 bg-green-100 border-2 border-green-600 text-green-900 px-4 py-3 rounded relative font-bold" id="success-message" style="color: #14532d !important;">
                    {{ session('success') }}
                </div>
                @if(session('redirect_after'))
                    <script>
                        setTimeout(function() {
                            window.location.href = '{{ session('redirect_url', route('leveranciers.show', $leverancier->Id)) }}';
                        }, {{ session('redirect_after') * 1000 }});
                    </script>
                @endif
            @endif

            @if(session('error'))
                <div class="mb-4 bg-red-100 border-2 border-red-600 text-red-900 px-4 py-3 rounded relative font-bold" id="error-message" style="color: #7f1d1d !important;">
                    {{ session('error') }}
                </div>
                @if(session('redirect_after'))
                    <script>
                        setTimeout(function() {
                            window.location.href = '{{ session('redirect_url', route('leveranciers.show', $leverancier->Id)) }}';
                        }, {{ session('redirect_after') * 1000 }});
                    </script>
                @endif
            @endif

            <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
                <div class="p-6 text-gray-900">
                    <div class="mb-6">
                        <h3 class="text-2xl font-bold mb-4">Leverancier Details: {{ $leverancier->Naam }}</h3>
                        
                        <div class="mb-4">
                            <a href="{{ route('leveranciers.wijzigen') }}" 
                               class="inline-flex items-center px-4 py-2 bg-gray-500 hover:bg-gray-600 text-white rounded-lg transition-colors duration-200">
                                <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5 mr-2" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 19l-7-7m0 0l7-7m-7 7h18" />
                                </svg>
                                Terug naar overzicht
                            </a>
                        </div>

                        <div class="bg-blue-50 p-6 rounded-lg border border-blue-200">
                            <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                                <div>
                                    <span class="font-semibold text-gray-700">Naam:</span>
                                    <span class="text-gray-900 ml-2">{{ $leverancier->Naam }}</span>
                                </div>
                                <div>
                                    <span class="font-semibold text-gray-700">Contactpersoon:</span>
                                    <span class="text-gray-900 ml-2">{{ $leverancier->ContactPersoon }}</span>
                                </div>
                                <div>
                                    <span class="font-semibold text-gray-700">Leveranciernummer:</span>
                                    <span class="text-gray-900 ml-2">{{ $leverancier->LeverancierNummer }}</span>
                                </div>
                                <div>
                                    <span class="font-semibold text-gray-700">Mobiel:</span>
                                    <span class="text-gray-900 ml-2">{{ $leverancier->Mobiel }}</span>
                                </div>
                                <div>
                                    <span class="font-semibold text-gray-700">Straat:</span>
                                    <span class="text-gray-900 ml-2">{{ $leverancier->Straat }}</span>
                                </div>
                                <div>
                                    <span class="font-semibold text-gray-700">Huisnummer:</span>
                                    <span class="text-gray-900 ml-2">{{ $leverancier->Huisnummer }}</span>
                                </div>
                                <div>
                                    <span class="font-semibold text-gray-700">Postcode:</span>
                                    <span class="text-gray-900 ml-2">{{ $leverancier->Postcode }}</span>
                                </div>
                                <div>
                                    <span class="font-semibold text-gray-700">Stad:</span>
                                    <span class="text-gray-900 ml-2">{{ $leverancier->Stad }}</span>
                                </div>
                            </div>
                        </div>

                        <div class="mt-6">
                            <a href="{{ route('leveranciers.edit', $leverancier->Id) }}" 
                               class="inline-flex items-center px-6 py-3 bg-blue-500 hover:bg-blue-600 text-white rounded-lg transition-colors duration-200 font-semibold">
                                <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5 mr-2" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M11 5H6a2 2 0 00-2 2v11a2 2 0 002 2h11a2 2 0 002-2v-5m-1.414-9.414a2 2 0 112.828 2.828L11.828 15H9v-2.828l8.586-8.586z" />
                                </svg>
                                Wijzig
                            </a>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</x-app-layout>

