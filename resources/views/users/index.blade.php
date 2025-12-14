<x-app-layout>
    <x-slot name="header">
        <h2 class="font-bold text-2xl text-black leading-tight">
            {{ __('Gebruikersrollen') }}
        </h2>
    </x-slot>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white overflow-hidden shadow-xl sm:rounded-lg border border-gray-200">
                <div class="p-8 bg-gradient-to-r from-gray-50 to-gray-100">
                    @if(session('success'))
                        <div class="bg-green-100 border-l-4 border-green-500 text-green-700 px-4 py-3 rounded mb-6 shadow-md">
                            <strong>Success:</strong> {{ session('success') }}
                        </div>
                    @endif

                    <div class="overflow-x-auto shadow-lg rounded-lg">
                        <table class="min-w-full bg-white border border-gray-300">
                            <thead class="bg-gradient-to-r from-blue-600 to-blue-800">
                                <tr>
                                    <th class="px-6 py-4 border-b-2 border-blue-900 text-left text-sm font-bold text-white uppercase tracking-wider">
                                        NAAM
                                    </th>
                                    <th class="px-6 py-4 border-b-2 border-blue-900 text-left text-sm font-bold text-white uppercase tracking-wider">
                                        EMAIL
                                    </th>
                                    <th class="px-6 py-4 border-b-2 border-blue-900 text-left text-sm font-bold text-white uppercase tracking-wider">
                                        GEBRUIKERSROL
                                    </th>
                                    <th class="px-6 py-4 border-b-2 border-blue-900 text-center text-sm font-bold text-white uppercase tracking-wider">
                                        VERWIJDER
                                    </th>
                                    <th class="px-6 py-4 border-b-2 border-blue-900 text-center text-sm font-bold text-white uppercase tracking-wider">
                                        WIJZIG
                                    </th>
                                    <th class="px-6 py-4 border-b-2 border-blue-900 text-center text-sm font-bold text-white uppercase tracking-wider">
                                        DETAILS
                                    </th>
                                </tr>
                            </thead>
                            <tbody class="bg-white divide-y divide-gray-300">
                                @foreach($users as $user)
                                    <tr class="hover:bg-blue-50 transition-colors duration-200 border-b border-gray-200">
                                        <td class="px-6 py-4 whitespace-nowrap text-sm font-medium text-gray-900">
                                            {{ $user->name }}
                                        </td>
                                        <td class="px-6 py-4 whitespace-nowrap text-sm text-blue-600 font-medium">
                                            {{ $user->email }}
                                        </td>
                                        <td class="px-6 py-4 whitespace-nowrap text-sm font-semibold text-gray-800">
                                            @php
                                                $roleNames = [
                                                    'admin' => 'Admin',
                                                    'magazijn medewerker' => 'Magazijn Medewerker',
                                                    'inkoper' => 'Inkoper',
                                                    'logistiek medewerker' => 'Logistiek Medewerker'
                                                ];
                                            @endphp
                                            {{ $roleNames[$user->role] ?? ucfirst($user->role) }}
                                        </td>
                                        <td class="px-6 py-4 whitespace-nowrap text-center">
                                            <form action="{{ route('users.destroy', $user) }}" method="POST" onsubmit="return confirm('Weet je zeker dat je deze gebruiker wilt verwijderen?')" class="inline">
                                                @csrf
                                                @method('DELETE')
                                                <button type="submit" class="bg-red-600 hover:bg-red-700 text-white font-bold py-2 px-4 rounded-md shadow-md transition-all duration-200 transform hover:scale-105">
                                                    Verwijderen
                                                </button>
                                            </form>
                                        </td>
                                        <td class="px-6 py-4 whitespace-nowrap text-center">
                                            <a href="{{ route('users.edit', $user) }}" class="bg-green-600 hover:bg-green-700 text-white font-bold py-2 px-4 rounded-md shadow-md transition-all duration-200 transform hover:scale-105 inline-block">
                                                Wijzig
                                            </a>
                                        </td>
                                        <td class="px-6 py-4 whitespace-nowrap text-center">
                                            <a href="{{ route('users.show', $user) }}" class="bg-yellow-600 hover:bg-yellow-700 text-white font-bold py-2 px-4 rounded-md shadow-md transition-all duration-200 transform hover:scale-105 inline-block">
                                                Details
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