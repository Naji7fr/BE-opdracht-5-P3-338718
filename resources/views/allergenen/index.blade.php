<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 dark:text-gray-200 leading-tight">
            {{ __('Overzicht Allergenen') }}
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
                    <h3 class="text-2xl font-bold mb-4 text-gray-900">Overzicht Allergenen</h3>
                    <p class="mb-6 text-gray-900">Selecteer een allergeen om alleen producten met dat allergeen te tonen (gesorteerd A-Z op productnaam).</p>

                    <form method="GET" action="{{ route('allergenen.index') }}" class="mb-6 flex flex-wrap items-end gap-4">
                        <div class="min-w-[200px]">
                            <label for="allergeen_id" class="block text-sm font-medium text-gray-900 mb-1">Allergeen</label>
                            <select name="allergeen_id" id="allergeen_id"
                                    class="w-full rounded-md border-gray-300 shadow-sm focus:ring-blue-500 focus:border-blue-500 text-gray-900 bg-white">
                                <option value="">-- Alle producten met allergenen --</option>
                                @foreach($allergenen as $a)
                                    <option value="{{ $a->Id }}" {{ (string)$geselecteerdAllergeenId === (string)$a->Id ? 'selected' : '' }}>
                                        {{ $a->Naam }}
                                    </option>
                                @endforeach
                            </select>
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
                                    <th class="px-6 py-4 text-left text-xs font-bold text-white uppercase tracking-wider">
                                        Productnaam
                                    </th>
                                    <th class="px-6 py-4 text-left text-xs font-bold text-white uppercase tracking-wider">
                                        Allergeen
                                    </th>
                                    <th class="px-6 py-4 text-center text-xs font-bold text-white uppercase tracking-wider">
                                        Info
                                    </th>
                                </tr>
                            </thead>
                            <tbody class="bg-white divide-y divide-gray-200">
                                @forelse($producten as $p)
                                    <tr class="hover:bg-gray-50">
                                        <td class="px-6 py-4 whitespace-nowrap text-sm font-medium text-gray-900">
                                            {{ $p->ProductNaam }}
                                        </td>
                                        <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-500">
                                            {{ $p->AllergeenNaam ?? '-' }}
                                        </td>
                                        <td class="px-6 py-4 whitespace-nowrap text-center">
                                            <a href="{{ route('allergenen.leverancier', $p->ProductId) }}"
                                               class="inline-flex items-center justify-center p-2 bg-blue-500 hover:bg-blue-600 text-white rounded-lg transition-colors duration-200"
                                               title="Leveranciergegevens">
                                                ?
                                            </a>
                                        </td>
                                    </tr>
                                @empty
                                    <tr>
                                        <td colspan="3" class="px-6 py-8 text-center text-sm text-gray-500">
                                            Geen producten met allergenen gevonden.
                                        </td>
                                    </tr>
                                @endforelse
                            </tbody>
                        </table>
                    </div>

                    @if($producten->hasPages())
                        <div class="mt-4 text-gray-900">
                            {{ $producten->withQueryString()->links() }}
                        </div>
                    @endif
                </div>
            </div>
        </div>
    </div>
</x-app-layout>
