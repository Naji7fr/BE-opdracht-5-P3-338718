<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            {{ __('Overzicht geleverde producten') }}
        </h2>
    </x-slot>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="mb-4">
                <a href="{{ route('dashboard') }}"
                   class="inline-flex items-center px-4 py-2 bg-gray-500 hover:bg-gray-600 text-white rounded-lg transition-colors duration-200">
                    <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5 mr-2" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 19l-7-7m0 0l7-7m-7 7h18" />
                    </svg>
                    Terug naar homepage
                </a>
            </div>

            <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
                <div class="p-6 text-gray-900">
                    <h3 class="text-2xl font-bold mb-4 text-gray-900">Overzicht geleverde producten</h3>

                    <form method="GET" action="{{ route('geleverde-producten.index') }}" class="mb-6 flex flex-wrap items-end gap-4">
                        <div>
                            <label for="startdatum" class="block text-sm font-medium text-gray-900 mb-1">Startdatum</label>
                            <input type="date" name="startdatum" id="startdatum" value="{{ $startdatum ?? '' }}"
                                   class="rounded-md border-gray-300 shadow-sm focus:ring-blue-500 focus:border-blue-500 text-gray-900 bg-white">
                        </div>
                        <div>
                            <label for="einddatum" class="block text-sm font-medium text-gray-900 mb-1">Einddatum</label>
                            <input type="date" name="einddatum" id="einddatum" value="{{ $einddatum ?? '' }}"
                                   class="rounded-md border-gray-300 shadow-sm focus:ring-blue-500 focus:border-blue-500 text-gray-900 bg-white">
                        </div>
                        <button type="submit"
                                class="px-4 py-2 bg-blue-500 hover:bg-blue-600 text-white font-medium rounded-lg transition-colors duration-200">
                            Maak selectie
                        </button>
                    </form>

                    <div class="overflow-x-auto">
                        <table class="min-w-full divide-y divide-gray-200">
                            <thead style="background: linear-gradient(135deg, #1e3a8a 0%, #3b82f6 100%);">
                                <tr>
                                    <th class="px-6 py-4 text-left text-xs font-bold text-white uppercase tracking-wider">Naam Leverancier</th>
                                    <th class="px-6 py-4 text-left text-xs font-bold text-white uppercase tracking-wider">Contactpersoon</th>
                                    <th class="px-6 py-4 text-left text-xs font-bold text-white uppercase tracking-wider">Productnaam</th>
                                    <th class="px-6 py-4 text-left text-xs font-bold text-white uppercase tracking-wider">Totaal geleverd</th>
                                    <th class="px-6 py-4 text-center text-xs font-bold text-white uppercase tracking-wider">Specificatie</th>
                                </tr>
                            </thead>
                            <tbody class="bg-white divide-y divide-gray-200">
                                @if(count($leveringen) === 0)
                                    <tr>
                                        <td colspan="5" class="px-6 py-8 text-center text-gray-900 font-medium">
                                            @if($startdatum && $einddatum)
                                                Er zijn geen leveringen geweest van producten in deze periode
                                            @else
                                                Geen leveringen gevonden.
                                            @endif
                                        </td>
                                    </tr>
                                @else
                                    @foreach($leveringen as $row)
                                        <tr class="hover:bg-gray-50">
                                            <td class="px-6 py-4 whitespace-nowrap text-sm font-medium text-gray-900">{{ $row->LeverancierNaam }}</td>
                                            <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-500">{{ $row->ContactPersoon }}</td>
                                            <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-500">{{ $row->ProductNaam }}</td>
                                            <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-900 font-semibold">{{ $row->TotaalGeleverd }}</td>
                                            <td class="px-6 py-4 whitespace-nowrap text-center">
                                                @if($startdatum && $einddatum)
                                                    <a href="{{ route('geleverde-producten.specificatie', $row->ProductId) }}?startdatum={{ urlencode($startdatum) }}&einddatum={{ urlencode($einddatum) }}"
                                                       class="inline-flex items-center justify-center p-2 bg-blue-500 hover:bg-blue-600 text-white rounded-lg transition-colors duration-200"
                                                       title="Specificatie geleverde producten">?</a>
                                                @else
                                                    <span class="text-gray-400">—</span>
                                                @endif
                                            </td>
                                        </tr>
                                    @endforeach
                                @endif
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
        </div>
    </div>
</x-app-layout>
