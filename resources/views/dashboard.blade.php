<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 dark:text-gray-200 leading-tight">
            {{ __("Bienvenue sur AutomateXpertise, l'assistant automatisé du pentester:") }}
        </h2>
    </x-slot>
    <body class="antialiased">
        <div class="max-w-7x1 mx-auto p-6 lg:p-8">
            <div class="mt-16">
                <div class="grid grid-cols-1 md:grid-cols-2 gap-6 lg:gap-8">
                    <a href="{{ url('/recon') }}" class="scale-100 p-6 bg-white dark:bg-gray-800/50 dark:bg-gradient-to-bl from-gray-700/50 via-transparent dark:ring-1 dark:ring-inset dark:ring-white/5 rounded-lg shadow-2xl shadow-gray-500/20 dark:shadow-none flex motion-safe:hover:scale-[1.01] transition-all duration-250 focus:outline focus:outline-2 focus:outline-red-500">
                        <div>
                            <div class="h-16 w-16 bg-red-50 dark:bg-red-800/20 flex items-center justify-center rounded-full">
                                <svg fill="none" viewBox="0 0 24 24" stroke-width="1.5" class="w-7 h-7 stroke-red-500">
                                    <path stroke-linecap="round" stroke-linejoin="round" d="M12 6.042A8.967 8.967 0 006 3.75c-1.052 0-2.062.18-3 .512v14.25A8.987 8.987 0 016 18c2.305 0 4.408.867 6 2.292m0-14.25a8.966 8.966 0 016-2.292c1.052 0 2.062.18 3 .512v14.25A8.987 8.987 0 0018 18a8.967 8.967 0 00-6 2.292m0-14.25v14.25" />
                                </svg>
                            </div>

                            <h2 class="mt-6 text-xl font-semibold text-gray-900 dark:text-white">Reconnaissance - Information Gathering</h2>

                            <p class="mt-4 text-gray-500 dark:text-gray-400 text-sm leading-relaxed">
                                Cette première étape ultra importante consiste à collecter des informations sur la cible et permet de rechercher les premières vulnérabilités qui seront peut-être exploitable.
                            </p>
                        </div>

                        <svg fill="none" viewBox="0 0 24 24" stroke-width="1.5" class="self-center shrink-0 stroke-red-500 w-6 h-6 mx-6">
                            <path stroke-linecap="round" stroke-linejoin="round" d="M4.5 12h15m0 0l-6.75-6.75M19.5 12l-6.75 6.75" />
                        </svg>
                    </a>

                    <a href="{{ url('/scan') }}" class="scale-100 p-6 bg-white dark:bg-gray-800/50 dark:bg-gradient-to-bl from-gray-700/50 via-transparent dark:ring-1 dark:ring-inset dark:ring-white/5 rounded-lg shadow-2xl shadow-gray-500/20 dark:shadow-none flex motion-safe:hover:scale-[1.01] transition-all duration-250 focus:outline focus:outline-2 focus:outline-red-500">
                        <div>
                            <div class="h-16 w-16 bg-red-50 dark:bg-red-800/20 flex items-center justify-center rounded-full">
                                <svg fill="none" viewBox="0 0 24 24" stroke-width="1.5" class="w-7 h-7 stroke-red-500">
                                    <path stroke-linecap="round" d="M15.75 10.5l4.72-4.72a.75.75 0 011.28.53v11.38a.75.75 0 01-1.28.53l-4.72-4.72M4.5 18.75h9a2.25 2.25 0 002.25-2.25v-9a2.25 2.25 0 00-2.25-2.25h-9A2.25 2.25 0 002.25 7.5v9a2.25 2.25 0 002.25 2.25z" />
                                </svg>
                            </div>

                            <h2 class="mt-6 text-xl font-semibold text-gray-900 dark:text-white">Scanning & Enumeration</h2>

                            <p class="mt-4 text-gray-500 dark:text-gray-400 text-sm leading-relaxed">
                                Cette deuxième étape consiste à cartographier (inventorier) les différents éléments actifs du système d'information de la cible. Elle permet également de rechercher d'avantage de vulnérabilités sur la cible.
                            </p>
                        </div>

                        <svg fill="none" viewBox="0 0 24 24" stroke-width="1.5" class="self-center shrink-0 stroke-red-500 w-6 h-6 mx-6">
                            <path stroke-linecap="round" stroke-linejoin="round" d="M4.5 12h15m0 0l-6.75-6.75M19.5 12l-6.75 6.75" />
                        </svg>
                    </a>

                    <a href="{{ url('/files') }}" class="scale-100 p-6 bg-white dark:bg-gray-800/50 dark:bg-gradient-to-bl from-gray-700/50 via-transparent dark:ring-1 dark:ring-inset dark:ring-white/5 rounded-lg shadow-2xl shadow-gray-500/20 dark:shadow-none flex motion-safe:hover:scale-[1.01] transition-all duration-250 focus:outline focus:outline-2 focus:outline-red-500">
                        <div>
                            <div class="h-16 w-16 bg-red-50 dark:bg-red-800/20 flex items-center justify-center rounded-full">
                                <svg fill="none" viewBox="0 0 24 24" stroke-width="1.5" class="w-7 h-7 stroke-red-500">
                                    <path stroke-linecap="round" stroke-linejoin="round" d="M12 7.5h1.5m-1.5 3h1.5m-7.5 3h7.5m-7.5 3h7.5m3-9h3.375c.621 0 1.125.504 1.125 1.125V18a2.25 2.25 0 01-2.25 2.25M16.5 7.5V18a2.25 2.25 0 002.25 2.25M16.5 7.5V4.875c0-.621-.504-1.125-1.125-1.125H4.125C3.504 3.75 3 4.254 3 4.875V18a2.25 2.25 0 002.25 2.25h13.5M6 7.5h3v3H6v-3z" />
                                </svg>
                            </div>

                            <h2 class="mt-6 text-xl font-semibold text-gray-900 dark:text-white">Résultats des scans</h2>

                            <p class="mt-4 text-gray-500 dark:text-gray-400 text-sm leading-relaxed">
                                Espace permettant de consulter et télécharger l'ensemble des résultats des scans (non traité), des phases "Reconnaissance - Information Gathering" et "Scanning & Enumeration".
                            </p>
                        </div>

                        <svg fill="none" viewBox="0 0 24 24" stroke-width="1.5" class="self-center shrink-0 stroke-red-500 w-6 h-6 mx-6">
                            <path stroke-linecap="round" stroke-linejoin="round" d="M4.5 12h15m0 0l-6.75-6.75M19.5 12l-6.75 6.75" />
                        </svg>
                    </a>

                    <a href="{{ url('/analyses') }}" class="scale-100 p-6 bg-white dark:bg-gray-800/50 dark:bg-gradient-to-bl from-gray-700/50 via-transparent dark:ring-1 dark:ring-inset dark:ring-white/5 rounded-lg shadow-2xl shadow-gray-500/20 dark:shadow-none flex motion-safe:hover:scale-[1.01] transition-all duration-250 focus:outline focus:outline-2 focus:outline-red-500">
                        <div>
                            <div class="h-16 w-16 bg-red-50 dark:bg-red-800/20 flex items-center justify-center rounded-full">
                                <svg fill="none" viewBox="0 0 24 24" stroke-width="1.5" class="w-7 h-7 stroke-red-500">
                                    <path stroke-linecap="round" stroke-linejoin="round" d="M12 7.5h1.5m-1.5 3h1.5m-7.5 3h7.5m-7.5 3h7.5m3-9h3.375c.621 0 1.125.504 1.125 1.125V18a2.25 2.25 0 01-2.25 2.25M16.5 7.5V18a2.25 2.25 0 002.25 2.25M16.5 7.5V4.875c0-.621-.504-1.125-1.125-1.125H4.125C3.504 3.75 3 4.254 3 4.875V18a2.25 2.25 0 002.25 2.25h13.5M6 7.5h3v3H6v-3z" />
                                </svg>
                            </div>

                            <h2 class="mt-6 text-xl font-semibold text-gray-900 dark:text-white">Analyse des résultats et plan d'action</h2>

                            <p class="mt-4 text-gray-500 dark:text-gray-400 text-sm leading-relaxed">
                                Espace permettant de consulter l'analyse des résultats des scans avec le ou les plans d'action associés. Vous pourrez également avoir des KPI ou autres éléments nécessaires dans la rédaction de votre rapport.
                            </p>
                        </div>

                        <svg fill="none" viewBox="0 0 24 24" stroke-width="1.5" class="self-center shrink-0 stroke-red-500 w-6 h-6 mx-6">
                            <path stroke-linecap="round" stroke-linejoin="round" d="M4.5 12h15m0 0l-6.75-6.75M19.5 12l-6.75 6.75" />
                        </svg>
                    </a>
                </div>
            </div>
            <div class="mt-16">
                <div class="grid">
                    <div class="scale-100 p-6 bg-white dark:bg-gray-800/50 dark:bg-gradient-to-bl from-gray-700/50 via-transparent dark:ring-1 dark:ring-inset dark:ring-white/5 rounded-lg shadow-2xl shadow-gray-500/20 dark:shadow-none flex focus:outline focus:outline-2 focus:outline-red-500">
                        <div>
                            <div class="h-16 w-16 bg-red-50 dark:bg-red-800/20 flex items-center justify-center rounded-full">
                                <svg fill="none" viewBox="0 0 24 24" stroke-width="1.5" class="w-7 h-7 stroke-red-500">
                                    <path stroke-linecap="round" stroke-linejoin="round" d="M6.115 5.19l.319 1.913A6 6 0 008.11 10.36L9.75 12l-.387.775c-.217.433-.132.956.21 1.298l1.348 1.348c.21.21.329.497.329.795v1.089c0 .426.24.815.622 1.006l.153.076c.433.217.956.132 1.298-.21l.723-.723a8.7 8.7 0 002.288-4.042 1.087 1.087 0 00-.358-1.099l-1.33-1.108c-.251-.21-.582-.299-.905-.245l-1.17.195a1.125 1.125 0 01-.98-.314l-.295-.295a1.125 1.125 0 010-1.591l.13-.132a1.125 1.125 0 011.3-.21l.603.302a.809.809 0 001.086-1.086L14.25 7.5l1.256-.837a4.5 4.5 0 001.528-1.732l.146-.292M6.115 5.19A9 9 0 1017.18 4.64M6.115 5.19A8.965 8.965 0 0112 3c1.929 0 3.716.607 5.18 1.64" />
                                </svg>
                            </div>

                            <h2 class="mt-6 text-xl font-semibold text-gray-900 dark:text-white">Ressources Supplémentaires</h2>

                            <p class="mt-4 text-gray-500 dark:text-gray-400 text-sm leading-relaxed">
                                <a href="https://www.thehacker.recipes/" target="_blank" class="underline hover:text-gray-700 dark:hover:text-black focus:outline focus:outline-2 focus:rounded-sm focus:outline-red-500">TheHackerRecipes</a>
                                <a href="https://book.hacktricks.xyz/" target="_blank" class="underline hover:text-gray-700 dark:hover:text-black focus:outline focus:outline-2 focus:rounded-sm focus:outline-red-500">HackTricks</a>
                                <a href="https://cloud.hacktricks.xyz" target="_blank" class="underline hover:text-gray-700 dark:hover:text-black focus:outline focus:outline-2 focus:rounded-sm focus:outline-red-500">HackTricks-Cloud</a>
                                <a href="https://swisskyrepo.github.io/PayloadsAllTheThings/" target="_blank" class="underline hover:text-gray-700 dark:hover:text-black focus:outline focus:outline-2 focus:rounded-sm focus:outline-red-500">PayloadsAllTheThings</a>
                                <a href="https://pentestbook.six2dez.com/" target="_blank" class="underline hover:text-gray-700 dark:hover:text-black focus:outline focus:outline-2 focus:rounded-sm focus:outline-red-500">PentestBook</a>
                                <a href="https://www.ired.team/" target="_blank" class="underline hover:text-gray-700 dark:hover:text-black focus:outline focus:outline-2 focus:rounded-sm focus:outline-red-500">IredTeam</a>
                                <a href="https://wadcoms.github.io/" target="_blank" class="underline hover:text-gray-700 dark:hover:text-black focus:outline focus:outline-2 focus:rounded-sm focus:outline-red-500">WADComs</a>
                                <a href="https://lolbas-project.github.io/" target="_blank" class="underline hover:text-gray-700 dark:hover:text-black focus:outline focus:outline-2 focus:rounded-sm focus:outline-red-500">LOLBAS</a>
                                <a href="https://gtfobins.github.io/" target="_blank" class="underline hover:text-gray-700 dark:hover:text-black focus:outline focus:outline-2 focus:rounded-sm focus:outline-red-500">GTFOBins</a>
                                <a href="https://app.redstack.io/search" target="_blank" class="underline hover:text-gray-700 dark:hover:text-black focus:outline focus:outline-2 focus:rounded-sm focus:outline-red-500">RedStack</a>
                                <a href="https://viperone.gitbook.io/pentest-everything/" target="_blank" class="underline hover:text-gray-700 dark:hover:text-black focus:outline focus:outline-2 focus:rounded-sm focus:outline-red-500">Pentest-Everything</a>
                                <a href="https://cheatsheet.haax.fr/" target="_blank" class="underline hover:text-gray-700 dark:hover:text-black focus:outline focus:outline-2 focus:rounded-sm focus:outline-red-500">Offensive-Security-cheatsheet</a>
                            </p>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </body>
</x-app-layout>
