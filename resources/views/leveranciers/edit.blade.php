<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            {{ __('Wijzig Leveranciergegevens') }}
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
                    <h3 class="text-2xl font-bold mb-6">Wijzig Leveranciergegevens: {{ $leverancier->Naam }}</h3>

                    <div class="mb-4">
                        <a href="{{ route('leveranciers.show', $leverancier->Id) }}" 
                           class="inline-flex items-center px-4 py-2 bg-gray-500 hover:bg-gray-600 text-white rounded-lg transition-colors duration-200">
                            <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5 mr-2" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 19l-7-7m0 0l7-7m-7 7h18" />
                            </svg>
                            Terug naar details
                        </a>
                    </div>

                    <form method="POST" action="{{ route('leveranciers.update', $leverancier->Id) }}" class="space-y-6">
                        @csrf
                        @method('PUT')

                        <div class="bg-gray-50 p-6 rounded-lg border border-gray-200">
                            <h4 class="text-lg font-semibold mb-4 text-gray-800">Leveranciergegevens</h4>
                            
                            <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                                <div>
                                    <label for="naam" class="block text-sm font-medium text-gray-700 mb-2">
                                        Naam <span class="text-red-500">*</span>
                                    </label>
                                    <input type="text" 
                                           name="naam" 
                                           id="naam" 
                                           value="{{ old('naam', $leverancier->Naam) }}" 
                                           required
                                           class="w-full px-3 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-blue-500">
                                    @error('naam')
                                        <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                                    @enderror
                                </div>

                                <div>
                                    <label for="contactpersoon" class="block text-sm font-medium text-gray-700 mb-2">
                                        Contactpersoon <span class="text-red-500">*</span>
                                    </label>
                                    <input type="text" 
                                           name="contactpersoon" 
                                           id="contactpersoon" 
                                           value="{{ old('contactpersoon', $leverancier->ContactPersoon) }}" 
                                           required
                                           class="w-full px-3 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-blue-500">
                                    @error('contactpersoon')
                                        <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                                    @enderror
                                </div>

                                <div>
                                    <label for="leveranciernummer" class="block text-sm font-medium text-gray-700 mb-2">
                                        Leveranciernummer <span class="text-red-500">*</span>
                                    </label>
                                    <input type="text" 
                                           name="leveranciernummer" 
                                           id="leveranciernummer" 
                                           value="{{ old('leveranciernummer', $leverancier->LeverancierNummer) }}" 
                                           required
                                           class="w-full px-3 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-blue-500">
                                    @error('leveranciernummer')
                                        <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                                    @enderror
                                </div>

                                <div>
                                    <label for="mobiel" class="block text-sm font-medium text-gray-700 mb-2">
                                        Mobiel <span class="text-red-500">*</span>
                                    </label>
                                    <input type="text" 
                                           name="mobiel" 
                                           id="mobiel" 
                                           value="{{ old('mobiel', $leverancier->Mobiel) }}" 
                                           required
                                           class="w-full px-3 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-blue-500">
                                    @error('mobiel')
                                        <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                                    @enderror
                                </div>
                            </div>
                        </div>

                        <div class="bg-gray-50 p-6 rounded-lg border border-gray-200">
                            <h4 class="text-lg font-semibold mb-4 text-gray-800">Adresgegevens</h4>
                            
                            <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                                <div>
                                    <label for="straat" class="block text-sm font-medium text-gray-700 mb-2">
                                        Straat <span class="text-red-500">*</span>
                                    </label>
                                    <input type="text" 
                                           name="straat" 
                                           id="straat" 
                                           value="{{ old('straat', $leverancier->Straat) }}" 
                                           required
                                           class="w-full px-3 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-blue-500">
                                    @error('straat')
                                        <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                                    @enderror
                                </div>

                                <div>
                                    <label for="huisnummer" class="block text-sm font-medium text-gray-700 mb-2">
                                        Huisnummer <span class="text-red-500">*</span>
                                    </label>
                                    <input type="text" 
                                           name="huisnummer" 
                                           id="huisnummer" 
                                           value="{{ old('huisnummer', $leverancier->Huisnummer) }}" 
                                           required
                                           class="w-full px-3 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-blue-500">
                                    @error('huisnummer')
                                        <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                                    @enderror
                                </div>

                                <div>
                                    <label for="postcode" class="block text-sm font-medium text-gray-700 mb-2">
                                        Postcode <span class="text-red-500">*</span>
                                    </label>
                                    <input type="text" 
                                           name="postcode" 
                                           id="postcode" 
                                           value="{{ old('postcode', $leverancier->Postcode) }}" 
                                           required
                                           class="w-full px-3 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-blue-500">
                                    @error('postcode')
                                        <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                                    @enderror
                                </div>

                                <div>
                                    <label for="stad" class="block text-sm font-medium text-gray-700 mb-2">
                                        Stad <span class="text-red-500">*</span>
                                    </label>
                                    <input type="text" 
                                           name="stad" 
                                           id="stad" 
                                           value="{{ old('stad', $leverancier->Stad) }}" 
                                           required
                                           class="w-full px-3 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-blue-500">
                                    @error('stad')
                                        <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                                    @enderror
                                </div>
                            </div>
                        </div>

                        <div class="flex items-center justify-end space-x-4">
                            <a href="{{ route('leveranciers.show', $leverancier->Id) }}" 
                               class="px-6 py-2 bg-gray-500 hover:bg-gray-600 text-white rounded-lg transition-colors duration-200">
                                Annuleren
                            </a>
                            <button type="submit" 
                                    class="px-6 py-2 bg-blue-500 hover:bg-blue-600 text-white rounded-lg transition-colors duration-200 font-semibold">
                                Sla op
                            </button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
</x-app-layout>

