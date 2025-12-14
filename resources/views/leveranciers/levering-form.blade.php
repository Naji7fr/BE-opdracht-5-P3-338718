<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            {{ __('Levering Product') }}
        </h2>
    </x-slot>

    <div class="py-12">
        <div class="max-w-3xl mx-auto sm:px-6 lg:px-8">
            <!-- Error Message with Redirect -->
            @if(session('error'))
                <div class="mb-4 bg-red-100 border border-red-400 text-red-700 px-4 py-3 rounded relative">
                    <strong class="font-bold">Let op!</strong>
                    <span class="block sm:inline">{{ session('error') }}</span>
                    
                    @if(session('redirect_after'))
                        <p class="mt-2 text-sm">U wordt over {{ session('redirect_after') }} seconden doorgestuurd...</p>
                        
                        <script>
                            setTimeout(function() {
                                window.location.href = "{{ session('redirect_url') }}";
                            }, {{ session('redirect_after') * 1000 }});
                        </script>
                    @endif
                </div>
            @endif

            <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
                <div class="p-6 text-gray-900">
                    <h3 class="text-2xl font-bold mb-6">Nieuwe Levering Toevoegen</h3>

                    <div class="mb-6 p-4 bg-blue-50 rounded-lg">
                        <h4 class="font-semibold text-lg mb-2">Leverancier: {{ $leverancier->Naam }}</h4>
                        <p class="text-gray-700"><strong>Product:</strong> {{ $product->Naam }}</p>
                        <p class="text-gray-700"><strong>Barcode:</strong> {{ $product->Barcode }}</p>
                        @if($product->magazijn)
                            <p class="text-gray-700"><strong>Huidig voorraad:</strong> {{ $product->magazijn->AantalAanwezig ?? 'N/A' }} stuks</p>
                        @endif
                        @if($product->IsActief == 0)
                            <p class="text-red-600 mt-2"><strong>⚠️ Let op:</strong> Dit product is niet meer actief</p>
                        @endif
                    </div>

                    <form method="POST" action="{{ route('leveranciers.levering.store', [$leverancier->Id, $product->Id]) }}" class="space-y-6">
                        @csrf

                        <!-- Aantal Producteenheden -->
                        <div>
                            <label for="aantal" class="block text-sm font-medium text-gray-700 mb-2">
                                Aantal Producteenheden *
                            </label>
                            <input type="number" 
                                   name="aantal" 
                                   id="aantal" 
                                   min="1"
                                   required
                                   value="{{ old('aantal') }}"
                                   class="mt-1 block w-full px-3 py-2 border border-gray-300 rounded-md shadow-sm focus:outline-none focus:ring-blue-500 focus:border-blue-500 sm:text-sm"
                                   placeholder="Voer het aantal producteenheden in">
                            @error('aantal')
                                <p class="mt-2 text-sm text-red-600">{{ $message }}</p>
                            @enderror
                        </div>

                        <!-- Datum Eerstvolgende Levering -->
                        <div>
                            <label for="datum_volgende_levering" class="block text-sm font-medium text-gray-700 mb-2">
                                Datum Eerstvolgende Levering
                            </label>
                            <input type="date" 
                                   name="datum_volgende_levering" 
                                   id="datum_volgende_levering"
                                   value="{{ old('datum_volgende_levering') }}"
                                   min="1900-01-01"
                                   max="2026-12-31"
                                   class="mt-1 block w-full px-3 py-2 border border-gray-300 rounded-md shadow-sm focus:outline-none focus:ring-blue-500 focus:border-blue-500 sm:text-sm">
                            @error('datum_volgende_levering')
                                <p class="mt-2 text-sm text-red-600">{{ $message }}</p>
                            @enderror
                        </div>

                        <!-- Buttons -->
                        <div class="flex items-center justify-between pt-4">
                            <a href="{{ route('leveranciers.producten', $leverancier->Id) }}" 
                               class="inline-flex items-center px-4 py-2 bg-gray-500 hover:bg-gray-600 text-white rounded-lg transition-colors duration-200">
                                <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5 mr-2" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 19l-7-7m0 0l7-7m-7 7h18" />
                                </svg>
                                Annuleren
                            </a>
                            
                            <button type="submit" 
                                    class="inline-flex items-center px-6 py-2 bg-green-600 hover:bg-green-700 text-white font-semibold rounded-lg transition-colors duration-200">
                                <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5 mr-2" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7" />
                                </svg>
                                Sla op
                            </button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
</x-app-layout>
