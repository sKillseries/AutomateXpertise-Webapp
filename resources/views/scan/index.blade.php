<x-app-layout>
    <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.15.4/css/all.min.css" rel="stylesheet">
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight dark:text-white">
            {{ __("Scanning & Enumeration") }}
        </h2>
    </x-slot>
    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8 space-y-6">
            <div class="p-6 bg-white dark:bg-gray-800/50 dark:bg-gradient-to-bl from-gray-700/50 via-transparent rounded-lg shadow-2xl shadow-gray-500/20 dark:shadow-none flex">
                <div class="max-w-xl">
                    <h2 class="mt-6 text-xl font-semibold text-gray-900 dark:text-white">Execute Scan Scripts</h2>
                    <br>
                    <form method="post" action="{{ url('/execute-scan') }}" class="mt-6 space-y-6">
                        @csrf
                        <div>
                            <x-input-label for="cible" class="mt-4 text-m leading-relaxed dark:text-white" :value="__('Cible (URL, IP, Domaine) :')"/>
                            <x-text-input class="mt-1 block w-full" type="text" name="cible" id="cible" required />
                        </div>
                        <br>
                        <div>
                            <label for="cible_arguments" class="mt-4 text-m leading-relaxed dark:text-white">Masque réseaux (CIDR) e.g /24 <i class="fas fa-info-circle" title="Nécessaire que pour les scripts multihosts et hostdiscovery"></i> :</label>
                            <x-text-input class="mt-1 block w-full" type="text" name="cible_arguments" id="cible_arguments" />
                            <p class="dark:text-white"> Ne pas mettre le "/" mettez juste la valeur CIDR</p>
                        </div>
                        <br>
                        <label class="mt-6 text-xl font-semibold text-gray-900 dark:text-white">Execute Scripts :</label><br>
                        @foreach ($scriptFiles as $scriptFile)
                            <?php $scriptName = pathinfo(basename($scriptFile), PATHINFO_FILENAME); ?>
                            <label class="mt-4 text-gray-500 text-m leading-relaxed">
                                <input type="checkbox" name="selected_scripts[]" value="{{ basename($scriptFile) }}">
                                {{ $scriptName }}
                            </label><br>
                        @endforeach
                        <br>
                        <button type="submit" class="text-l font-semibold text-white scale-100 p-6 bg-red-500 rounded-lg shadow-2xl flex motion-safe:hover:scale-[1.01] transition-all duration-250 focus:outline focus:outline-2 focus:outline-red-500">Execute Selected Scripts
                        </button>
                        @if (isset($messages))
                            <h2 class="mt-6 text-xl font-semibold text-gray-900 dark:text-white">Output:</h2>
                            <pre class="mt-4 text-m leading-relaxed dark:text-white">{{ $messages }}</pre>
                        @endif
                    </form>
                </div>
            </div>
        </div>
    </div>
</x-app-layout>