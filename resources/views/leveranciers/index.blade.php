<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            {{ __('Overzicht Leveranciers') }}
        </h2>
    </x-slot>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
                <div class="p-6 text-gray-900">
                    <h3 class="text-2xl font-bold mb-6">Leveranciers van Jamin</h3>

                    <div class="overflow-x-auto">
                        <table class="min-w-full divide-y divide-gray-200">
                            <thead style="background: linear-gradient(135deg, #1e3a8a 0%, #3b82f6 100%);">
                                <tr>
                                    <th class="px-6 py-4 text-left text-xs font-bold text-white uppercase tracking-wider">
                                        Naam Leverancier
                                    </th>
                                    <th class="px-6 py-4 text-left text-xs font-bold text-white uppercase tracking-wider">
                                        Contactpersoon
                                    </th>
                                    <th class="px-6 py-4 text-left text-xs font-bold text-white uppercase tracking-wider">
                                        Leveranciernummer
                                    </th>
                                    <th class="px-6 py-4 text-left text-xs font-bold text-white uppercase tracking-wider">
                                        Mobiel
                                    </th>
                                    <th class="px-6 py-4 text-left text-xs font-bold text-white uppercase tracking-wider">
                                        Aantal Verschillende Producten
                                    </th>
                                    <th class="px-6 py-4 text-center text-xs font-bold text-white uppercase tracking-wider">
                                        Toon Producten
                                    </th>
                                </tr>
                            </thead>
                            <tbody class="bg-white divide-y divide-gray-200">
                                @foreach($leveranciers as $leverancier)
                                    <tr class="hover:bg-gray-50">
                                        <td class="px-6 py-4 whitespace-nowrap text-sm font-medium text-gray-900">
                                            {{ $leverancier->Naam }}
                                        </td>
                                        <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-500">
                                            {{ $leverancier->ContactPersoon }}
                                        </td>
                                        <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-500">
                                            {{ $leverancier->LeverancierNummer }}
                                        </td>
                                        <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-500">
                                            {{ $leverancier->Mobiel }}
                                        </td>
                                        <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-900 font-semibold text-center">
                                            {{ $leverancier->AantalVerschillendeProducten }}
                                        </td>
                                        <td class="px-6 py-4 whitespace-nowrap text-center">
                                            <a href="{{ route('leveranciers.producten', $leverancier->Id) }}" 
                                               class="inline-flex items-center justify-center p-2 bg-blue-500 hover:bg-blue-600 text-white rounded-lg transition-colors duration-200"
                                               title="Toon producten">
                                                <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M20 7l-8-4-8 4m16 0l-8 4m8-4v10l-8 4m0-10L4 7m8 4v10M4 7v10l8 4" />
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
