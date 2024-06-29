<x-app-layout>
    <x-slot name="header">
        <div class="flex items-center justify-between dark:border-primary-darker">
            <h2 class="font-semibold text-xl text-gray-800 leading-tight dark:text-white">
                {{ __("Résultat de l'analyse des scans") }}
            </h2>
            <a href="#" class="px-4 text-l font-semibold text-white scale-100 p-2 rounded-lg bg-red-500 shadow-2xl flex motion-safe:hover:scale-[1.01] transition-all duration-250 focus:outline focus:outline-2 focus:outline-red-500">
                Lancement Analyse
            </a>
        </div>
    </x-slot>
    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8 space-y-6">
            <div class="p-4 sm:p-8 bg-white dark:bg-gray-800/50 dark:bg-gradient-to-bl shadow sm:rounded-lg">
                 <!-- TODO -->
                <p class="font-semibold text-xm text-gray-800 dark:text-white text-center"> Work in progress</p>
            </div>
        </div>
    </div>
</x-app-layout>