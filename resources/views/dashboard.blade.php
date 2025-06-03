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
                    {{ __("You're logged in!") }}
                </div>
            </div>
            <div class="mt-4 flex items-center justify-center">
                <a href="{{ route('map') }}" class="inline-flex items-center px-6 py-3 text-base font-medium leading-6 text-white transition duration-150 ease-in-out bg-green-500 dark:bg-green-700 border border-transparent rounded-md hover:bg-green-600 dark:hover:bg-green-800 focus:outline-none focus:bg-green-600 dark:focus:bg-green-800 active:bg-green-700 dark:active:bg-green-900" style="background-image: linear-gradient(to right, #34C759, #008000);">
                    Pergi ke Map
                </a>
            </div>
        </div>
    </div>
</x-app-layout>

