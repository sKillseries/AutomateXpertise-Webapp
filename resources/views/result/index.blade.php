<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight dark:text-white">
            {{ __("Résultat des scans") }}
        </h2>
    </x-slot>
    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8 space-y-6">
            <div class="p-4 sm:p-8 bg-white dark:bg-gray-800/50 dark:bg-gradient-to-bl shadow sm:rounded-lg">
                <div class="max-w-xl">
                    <ul>
                        @foreach ($items as $item)
                            <li>
                                <div class="flex justify-between">
                                    <div class="flex">
                                        <div class="hidden space-x-8 sm:-my-px sm:ms-10 sm:flex">
                                            <a href="{{ route('view', $item->getBasename()) }}" class="mt-4 text-gray-500 text-m leading-relaxed dark:text-white">{{ $item->getBasename() }} - Voir</a>
                                        </div>
                                    </div>
                                    <div class="hidden sm:flex sm:items-center sm:ms-6">
                                        <x-dropdown align="right" width="48">
                                            <x-slot name="trigger">
                                                <button class="inline-flex items-center px-3 py-2 border border-transparent text-sm leading-4 font-medium rounded-md text-gray-500 dark:text-gray-400 bg-white dark:bg-gray-800 hover:text-gray-700 dark:hover:text-gray-300 focus:outline-none transition ease-in-out duration-150">
                                                    <div>Download</div>

                                                    <div class="ms-1">
                                                        <svg class="fill-current h-4 w-4" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 20 20">
                                                            <path fill-rule="evenodd" d="M5.293 7.293a1 1 0 011.414 0L10 10.586l3.293-3.293a1 1 0 111.414 1.414l-4 4a1 1 0 01-1.414 0l-4-4a1 1 0 010-1.414z" clip-rule="evenodd" />
                                                        </svg>
                                                    </div>
                                                </button>
                                            </x-slot>

                                            <x-slot name="content">
                                                <x-dropdown-link :href="route('download', $item->getBasename())">HTML</x-dropdown-link>
                                                <x-dropdown-link :href="route('markdown', $item->getBasename())">Markdown</x-dropdown-link>
                                                <x-dropdown-link :href="route('pdf', $item->getBasename())">PDF</x-dropdown-link>
                                                <x-dropdown-link :href="route('word', $item->getBasename())">Word</x-dropdown-link>
                                            </x-slot>
                                        </x-dropdown>
                                    </div>
                                </div>
                            </li>
                        @endforeach
                    </ul>
                </div>
            </div>
        </div>
    </div>
</x-app-layout>