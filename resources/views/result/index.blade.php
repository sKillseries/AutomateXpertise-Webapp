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
                                <p class="mt-4 text-gray-500 text-m leading-relaxed dark:text-white">{{ $item->getBasename() }}
                                |
                                <a href="{{ route('view', $item->getBasename()) }}">Voir</a>
                                |
                                Download:
                                <a href="{{ route('download', $item->getBasename()) }}">html</a>
                                <a href="{{ route('markdown', $item->getBasename()) }}">markdown</a>
                                <a href="{{ route('pdf', $item->getBasename()) }}">pdf</a></p>
                            </li>
                        @endforeach
                    </ul>
                </div>
            </div>
        </div>
    </div>
</x-app-layout>