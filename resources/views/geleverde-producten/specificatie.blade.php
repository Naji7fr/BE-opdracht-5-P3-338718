<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            {{ __('Specificatie geleverde producten') }}
        </h2>
    </x-slot>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="mb-4">
                <a href="{{ route('geleverde-producten.index') }}?startdatum={{ urlencode($startdatum) }}&einddatum={{ urlencode($einddatum) }}"
                   class="inline-flex items-center px-4 py-2 bg-gray-500 hover:bg-gray-600 text-white rounded-lg transition-colors duration-200">
                    <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5 mr-2" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 19l-7-7m0 0l7-7m-7 7h18" />
                    </svg>
                    Terug naar overzicht
                </a>
            </div>

            <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
                <div class="p-6 text-gray-900">
                    <h3 class="text-2xl font-bold mb-6 text-gray-900">Specificatie geleverde producten</h3>

                    <div class="mb-6 space-y-2">
                        <p><span class="font-semibold text-gray-900">Startdatum:</span> {{ \Carbon\Carbon::parse($startdatum)->format('d-m-Y') }}</p>
                        <p><span class="font-semibold text-gray-900">Einddatum:</span> {{ \Carbon\Carbon::parse($einddatum)->format('d-m-Y') }}</p>
                        <p><span class="font-semibold text-gray-900">Productnaam:</span> {{ $product->Naam }}</p>
                        <p><span class="font-semibold text-gray-900">Allergenen:</span> {{ count($allergenenNamen) ? implode(', ', $allergenenNamen) : 'Geen' }}</p>
                    </div>

                    <div class="overflow-x-auto">
                        <table class="min-w-full divide-y divide-gray-200">
                            <thead style="background: linear-gradient(135deg, #1e3a8a 0%, #3b82f6 100%);">
                                <tr>
                                    <th class="px-6 py-4 text-left text-xs font-bold text-white uppercase tracking-wider">Datum levering</th>
                                    <th class="px-6 py-4 text-left text-xs font-bold text-white uppercase tracking-wider">Aantal</th>
                                </tr>
                            </thead>
                            <tbody class="bg-white divide-y divide-gray-200">
                                @foreach($specificaties as $s)
                                    <tr class="hover:bg-gray-50">
                                        <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-900">{{ \Carbon\Carbon::parse($s->DatumLevering)->format('d-m-Y') }}</td>
                                        <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-500">{{ $s->Aantal }}</td>
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
