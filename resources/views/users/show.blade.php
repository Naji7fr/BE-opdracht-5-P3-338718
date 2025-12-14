<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            {{ __('Gebruiker Details') }}
        </h2>
    </x-slot>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white overflow-hidden shadow-xl sm:rounded-lg border border-gray-200">
                <div class="p-8 bg-gradient-to-r from-gray-50 to-gray-100">
                    <div class="grid grid-cols-1 lg:grid-cols-2 gap-8">
                        <!-- User Information Card -->
                        <div class="bg-white rounded-lg shadow-md p-6 border border-gray-200">
                            <h3 class="text-xl font-bold text-gray-900 mb-6 border-b-2 border-blue-500 pb-2">Gebruikersinformatie</h3>
                            
                            <div class="space-y-4">
                                <div class="flex items-center space-x-3">
                                    <div class="w-12 h-12 bg-blue-100 rounded-full flex items-center justify-center">
                                        <span class="text-blue-600 font-bold text-lg">{{ substr($user->name, 0, 1) }}</span>
                                    </div>
                                    <div>
                                        <label class="block text-sm font-bold text-gray-700">Naam</label>
                                        <p class="text-lg text-gray-900 font-semibold">{{ $user->name }}</p>
                                    </div>
                                </div>

                                <div class="bg-gray-50 p-3 rounded-lg">
                                    <label class="block text-sm font-bold text-gray-700">Email</label>
                                    <p class="text-lg text-blue-600 font-medium">{{ $user->email }}</p>
                                </div>

                                <div class="bg-gray-50 p-3 rounded-lg">
                                    <label class="block text-sm font-bold text-gray-700">Gebruikersrol</label>
                                    @php
                                        $roleClasses = match($user->role) {
                                            'admin' => 'bg-red-100 text-red-800',
                                            'magazijnmedewerker' => 'bg-blue-100 text-blue-800', 
                                            'inkoper' => 'bg-green-100 text-green-800',
                                            'logistiek' => 'bg-yellow-100 text-yellow-800',
                                            default => 'bg-gray-100 text-gray-800'
                                        };
                                        
                                        $roleNames = [
                                            'admin' => 'Admin',
                                            'magazijn medewerker' => 'Magazijn Medewerker',
                                            'inkoper' => 'Inkoper',
                                            'logistiek medewerker' => 'Logistiek Medewerker'
                                        ];
                                    @endphp
                                    <span class="inline-flex items-center px-3 py-1 rounded-full text-sm font-medium {{ $roleClasses }}">
                                        {{ $roleNames[$user->role] ?? ucfirst($user->role) }}
                                    </span>
                                </div>
                            </div>
                        </div>

                        <!-- Account Details Card -->
                        <div class="bg-white rounded-lg shadow-md p-6 border border-gray-200">
                            <h3 class="text-xl font-bold text-gray-900 mb-6 border-b-2 border-green-500 pb-2">Account Details</h3>
                            
                            <div class="space-y-4">
                                <div class="bg-gray-50 p-3 rounded-lg">
                                    <label class="block text-sm font-bold text-gray-700">Account ID</label>
                                    <p class="text-lg text-gray-900 font-mono">#{{ $user->id }}</p>
                                </div>

                                <div class="bg-gray-50 p-3 rounded-lg">
                                    <label class="block text-sm font-bold text-gray-700">Aangemaakt op</label>
                                    <p class="text-lg text-gray-900">{{ $user->created_at->format('d-m-Y H:i') }}</p>
                                    <p class="text-sm text-gray-600">{{ $user->created_at->diffForHumans() }}</p>
                                </div>

                                <div class="bg-gray-50 p-3 rounded-lg">
                                    <label class="block text-sm font-bold text-gray-700">Laatst bijgewerkt</label>
                                    <p class="text-lg text-gray-900">{{ $user->updated_at->format('d-m-Y H:i') }}</p>
                                    <p class="text-sm text-gray-600">{{ $user->updated_at->diffForHumans() }}</p>
                                </div>

                                <div class="bg-gray-50 p-3 rounded-lg">
                                    <label class="block text-sm font-bold text-gray-700">Account Status</label>
                                    <span class="inline-flex items-center px-3 py-1 rounded-full text-sm font-medium bg-green-100 text-green-800">
                                        <span class="w-2 h-2 bg-green-500 rounded-full mr-2"></span>
                                        Actief
                                    </span>
                                </div>
                            </div>
                        </div>
                    </div>

                    <div class="mt-6 flex items-center justify-between">
                        <a href="{{ route('users.index') }}" class="bg-gray-500 hover:bg-gray-700 text-white font-bold py-2 px-4 rounded">
                            Terug
                        </a>
                        <div class="space-x-2">
                            <a href="{{ route('users.edit', $user) }}" class="bg-green-500 hover:bg-green-700 text-white font-bold py-2 px-4 rounded">
                                Bewerken
                            </a>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</x-app-layout>