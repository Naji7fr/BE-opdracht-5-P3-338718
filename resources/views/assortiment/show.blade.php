<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            {{ __('Product') }}
        </h2>
    </x-slot>

    <div class="py-12">
        <div class="max-w-2xl mx-auto sm:px-6 lg:px-8">

            {{-- Back to overview --}}
            <div class="mb-4">
                <a href="{{ route('assortiment.index') }}?startdatum={{ urlencode($startdatum ?? '') }}&einddatum={{ urlencode($einddatum ?? '') }}"
                   class="inline-flex items-center px-4 py-2 bg-gray-500 hover:bg-gray-600 text-white rounded-lg transition-colors duration-200">
                    <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5 mr-2" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 19l-7-7m0 0l7-7m-7 7h18" />
                    </svg>
                    Terug naar overzicht
                </a>
            </div>

            {{-- Flash messages (Wireframe-04 green / Wireframe-06 red) --}}
            @if(session('success'))
                <div class="mb-4 px-4 py-3 rounded-lg bg-green-100 border border-green-400 text-green-800 font-medium">
                    {{ session('success') }}
                </div>
            @endif

            @if(session('error'))
                <div class="mb-4 px-4 py-3 rounded-lg bg-red-100 border border-red-400 text-red-800 font-medium">
                    {{ session('error') }}
                </div>
            @endif

            {{-- Product card (Wireframe-03 / 05) --}}
            <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
                <div class="p-6 text-gray-900">
                    <h3 class="text-xl font-bold mb-4 text-gray-900 border-b pb-2">Product</h3>

                    <table class="w-full text-sm">
                        <tbody class="divide-y divide-gray-100">
                            <tr>
                                <td class="py-2 pr-4 font-semibold text-gray-700 w-48">Naam Product:</td>
                                <td class="py-2 text-gray-900">{{ $product->Naam }}</td>
                            </tr>
                            <tr>
                                <td class="py-2 pr-4 font-semibold text-gray-700">Barcode:</td>
                                <td class="py-2 text-gray-900">{{ $product->Barcode }}</td>
                            </tr>
                            <tr>
                                <td class="py-2 pr-4 font-semibold text-gray-700">Bevat gluten</td>
                                <td class="py-2 {{ $product->BevatGluten === 'Ja' ? 'text-red-600 font-semibold' : 'text-gray-900' }}">
                                    {{ $product->BevatGluten }}
                                </td>
                            </tr>
                            <tr>
                                <td class="py-2 pr-4 font-semibold text-gray-700">Bevat gelatine</td>
                                <td class="py-2 {{ $product->BevatGelatine === 'Ja' ? 'text-red-600 font-semibold' : 'text-gray-900' }}">
                                    {{ $product->BevatGelatine }}
                                </td>
                            </tr>
                            <tr>
                                <td class="py-2 pr-4 font-semibold text-gray-700">Bevat AZO-Kleurstof</td>
                                <td class="py-2 {{ $product->BevatAZOKleurstof === 'Ja' ? 'text-red-600 font-semibold' : 'text-gray-900' }}">
                                    {{ $product->BevatAZOKleurstof }}
                                </td>
                            </tr>
                            <tr>
                                <td class="py-2 pr-4 font-semibold text-gray-700">Bevat lactose</td>
                                <td class="py-2 {{ $product->BevatLactose === 'Ja' ? 'text-red-600 font-semibold' : 'text-gray-900' }}">
                                    {{ $product->BevatLactose }}
                                </td>
                            </tr>
                            <tr>
                                <td class="py-2 pr-4 font-semibold text-gray-700">Bevat soja</td>
                                <td class="py-2 {{ $product->BevatSoja === 'Ja' ? 'text-red-600 font-semibold' : 'text-gray-900' }}">
                                    {{ $product->BevatSoja }}
                                </td>
                            </tr>
                        </tbody>
                    </table>

                    {{-- Verwijder button (POST form to avoid CSRF issues) --}}
                    <div class="mt-6">
                        <form method="POST"
                              action="{{ route('assortiment.destroy', $product->Id) }}?startdatum={{ urlencode($startdatum ?? '') }}&einddatum={{ urlencode($einddatum ?? '') }}">
                            @csrf
                            @method('DELETE')
                            <button type="submit"
                                    class="px-6 py-2 bg-red-500 hover:bg-red-600 text-white font-medium rounded-lg transition-colors duration-200">
                                Verwijder
                            </button>
                        </form>
                    </div>
                </div>
            </div>

        </div>
    </div>
</x-app-layout>
