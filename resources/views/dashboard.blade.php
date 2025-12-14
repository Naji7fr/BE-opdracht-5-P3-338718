<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 dark:text-gray-200 leading-tight">
            {{ __('Dashboard') }}
        </h2>
    </x-slot>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white dark:bg-gray-800 overflow-hidden shadow-sm sm:rounded-lg">
                <div class="p-6 text-gray-900 dark:text-gray-100">
                    <h3 class="text-2xl font-bold mb-4">{{ __("Welkom bij Jamin!") }}</h3>
                    <p class="mb-6">{{ __("You're logged in!") }}</p>
                    
                    <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                        <!-- Leveranciers Overview Link -->
                        <a href="{{ route('leveranciers.index') }}" 
                           class="block p-6 bg-blue-50 hover:bg-blue-100 border border-blue-200 rounded-lg transition-colors duration-200">
                            <div class="flex items-center">
                                <svg xmlns="http://www.w3.org/2000/svg" class="h-12 w-12 text-blue-600 mr-4" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M20 7l-8-4-8 4m16 0l-8 4m8-4v10l-8 4m0-10L4 7m8 4v10M4 7v10l8 4" />
                                </svg>
                                <div>
                                    <h4 class="text-xl font-semibold text-gray-800">Overzicht Leveranciers</h4>
                                    <p class="text-gray-600 mt-1">Bekijk leveranciers en hun producten</p>
                                </div>
                            </div>
                        </a>

                        @if(auth()->user()->role === 'admin')
                        <!-- User Management Link (Admin only) -->
                        <a href="{{ route('users.index') }}" 
                           class="block p-6 bg-green-50 hover:bg-green-100 border border-green-200 rounded-lg transition-colors duration-200">
                            <div class="flex items-center">
                                <svg xmlns="http://www.w3.org/2000/svg" class="h-12 w-12 text-green-600 mr-4" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4.354a4 4 0 110 5.292M15 21H3v-1a6 6 0 0112 0v1zm0 0h6v-1a6 6 0 00-9-5.197M13 7a4 4 0 11-8 0 4 4 0 018 0z" />
                                </svg>
                                <div>
                                    <h4 class="text-xl font-semibold text-gray-800">Gebruikersbeheer</h4>
                                    <p class="text-gray-600 mt-1">Beheer gebruikers en rollen</p>
                                </div>
                            </div>
                        </a>
                        @endif
                    </div>
                </div>
            </div>
        </div>
    </div>
</x-app-layout>
