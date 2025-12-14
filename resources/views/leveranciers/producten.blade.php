<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            {{ __('Geleverde Producten') }}
        </h2>
    </x-slot>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <!-- Success/Error Messages -->
            @if(session('success'))
                <div class="mb-4 bg-green-100 border border-green-400 text-green-700 px-4 py-3 rounded relative">
                    {{ session('success') }}
                </div>
            @endif

            <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
                <div class="p-6 text-gray-900">
                    <div class="mb-6 bg-blue-50 p-4 rounded-lg border border-blue-200">
                        <h3 class="text-2xl font-bold text-gray-800 mb-3">Geleverde producten door {{ $leverancier->Naam }}</h3>
                        <div class="grid grid-cols-1 md:grid-cols-3 gap-3">
                            <div>
                                <span class="font-semibold text-gray-700">Leveranciernummer:</span>
                                <span class="text-gray-900 ml-2">{{ $leverancier->LeverancierNummer }}</span>
                            </div>
                            <div>
                                <span class="font-semibold text-gray-700">Contactpersoon:</span>
                                <span class="text-gray-900 ml-2">{{ $leverancier->ContactPersoon }}</span>
                            </div>
                            <div>
                                <span class="font-semibold text-gray-700">Mobiel:</span>
                                <span class="text-gray-900 ml-2">{{ $leverancier->Mobiel }}</span>
                            </div>
                        </div>
                    </div>

                    <div class="mb-4">
                        <a href="{{ route('leveranciers.index') }}" 
                           class="inline-flex items-center px-4 py-2 bg-gray-500 hover:bg-gray-600 text-white rounded-lg transition-colors duration-200">
                            <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5 mr-2" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 19l-7-7m0 0l7-7m-7 7h18" />
                            </svg>
                            Terug naar leveranciers
                        </a>
                    </div>

                    <div class="overflow-x-auto">
                        <table class="min-w-full divide-y divide-gray-200">
                            <thead style="background: linear-gradient(135deg, #1e3a8a 0%, #3b82f6 100%);">
                                <tr>
                                    <th class="px-6 py-4 text-left text-xs font-bold text-white uppercase tracking-wider">
                                        Naam Product
                                    </th>
                                    <th class="px-6 py-4 text-left text-xs font-bold text-white uppercase tracking-wider">
                                        Aantal in Magazijn
                                    </th>
                                    <th class="px-6 py-4 text-left text-xs font-bold text-white uppercase tracking-wider">
                                        Verpakkingseenheid
                                    </th>
                                    <th class="px-6 py-4 text-left text-xs font-bold text-white uppercase tracking-wider">
                                        Laatste Levering
                                    </th>
                                    <th class="px-6 py-4 text-center text-xs font-bold text-white uppercase tracking-wider">
                                        Nieuwe Levering
                                    </th>
                                </tr>
                            </thead>
                            <tbody class="bg-white divide-y divide-gray-200">
                                @foreach($producten as $product)
                                    <tr class="hover:bg-gray-50">
                                        <td class="px-6 py-4 whitespace-nowrap text-sm font-medium text-gray-900">
                                            {{ $product->ProductNaam }}
                                            @if($product->ProductIsActief == 0)
                                                <span class="ml-2 px-2 py-1 text-xs bg-red-100 text-red-800 rounded">Niet actief</span>
                                            @endif
                                        </td>
                                        <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-900 font-semibold">
                                            {{ $product->AantalInMagazijn ?? 'N/A' }}
                                        </td>
                                        <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-500">
                                            {{ number_format($product->VerpakkingsEenheid, 1) }} kg
                                        </td>
                                        <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-500">
                                            {{ $product->Laatstelevering ? date('d-m-Y', strtotime($product->Laatstelevering)) : 'N/A' }}
                                        </td>
                                        <td class="px-6 py-4 whitespace-nowrap text-center">
                                            <a href="{{ route('leveranciers.levering.create', [$leverancier->Id, $product->ProductId]) }}" 
                                               class="inline-flex items-center justify-center p-2 bg-green-500 hover:bg-green-600 text-white rounded-lg transition-colors duration-200"
                                               title="Nieuwe levering">
                                                <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 6v6m0 0v6m0-6h6m-6 0H6" />
                                                </svg>
                                            </a>
                                        </td>
                                    </tr>
                                @endforeach
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
        </div>
    </div>
</x-app-layout>
