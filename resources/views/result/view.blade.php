<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight dark:text-white">
            {{ __("Contenu du fichier : $filename ") }}
        </h2>
    </x-slot>
    <div class="py-12">
        <div class="max-w-10xl mx-auto sm:px-6 lg:px-8 space-y-6">
            <div class="p-4 sm:p-8 bg-white dark:bg-gray-800 shadow sm:rounded-lg">
                <div class="bg-white dark:bg-gray-800">
                    <pre>{!! $content !!}</pre>
                </div>
            </div>
        </div>
    </div>
</x-app-layout>