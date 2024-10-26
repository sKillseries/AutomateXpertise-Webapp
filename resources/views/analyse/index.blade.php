<x-app-layout>
    <x-slot name="header">
        <div class="flex items-center justify-between dark:border-primary-darker">
            <h2 class="font-semibold text-xl text-gray-800 leading-tight dark:text-white">
                {{ __("Résultat de l'analyse des scans") }}
            </h2>
            <a href="{{ url('execute-analyses') }}" class="px-4 text-l font-semibold text-white scale-100 p-2 rounded-lg bg-red-500 shadow-2xl flex motion-safe:hover:scale-[1.01] transition-all duration-250 focus:outline focus:outline-2 focus:outline-red-500">
                Lancement Analyse
            </a>
        </div>
    </x-slot>
    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8 space-y-6">
            <div class="p-4 sm:p-8 bg-white dark:bg-gray-800/50 dark:bg-gradient-to-bl shadow sm:rounded-lg">
                 <!-- Affichage des messages si présent -->
                @if (isset($messages))
                    <pre class="mt-4 text-m leading-relaxed dark:text-white">{{ $messages }}</pre>
                @endif
                <!-- Affichage du graphique -->
                <h2 class="text-2xl font-semibold text-gray-800 text-center dark:text-white mb-6">Vulnérabilités identifiées</h2>
                <div class="w-full max-w-2xl mx-auto">
                    <canvas id="severityChart"></canvas>
                </div>
                <p class="font-semibold text-xm text-gray-800 dark:text-white text-center"> Work in progress</p>
            </div>
        </div>
    </div>

    <!-- Chart.js -->
    <script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
    <script>
        // Données récupérées depuis le contrôleur
        const severityData = @json($severityCounts);

        // Extraction des labels et des valeurs
        const labels = Object.keys(severityData);
        const data = Object.values(severityData);

        // Couleurs pour chaque type de sévérité
        cont backgroundColors = {
            'Low': 'rgba(52, 211, 153, 0.6)', //Vert
            'Medium': 'rgba(255, 211, 92, 0.6)', //Jaune
            'High': 'rgba(255, 159, 28, 0.6)', //Orange
            'Critical': 'rgba(239, 68, 68, 0.6)', //Rouge
        };

        // Préparation des données pour le  graphique
        const datasets = [{
            label: 'Nombre de vulnérabilités',
            data: data,
            backgroundColor: labels.map(severity => backgroundColors[severity] || 'rgba(75, 192, 192, 0.6)'),
            borderColor: labels.map(severity => backgroundColors[severity]?.replace('0.6', '1') || 'rgba(75, 192, 192, 1)'),
            borderWidth: 1
        }];

        const ctx = document.getElementById('severityChart').getContext('2d');
        const severityChart = new Chart(ctx, {
            type: 'bar', // Type de diagramme en barres
            data: {
                labels: labels, // Sévérités (étiquettes)
                datasets: datasets,
            },
            options: {
                responsive: true,
                maintainAspectRatio: false,
                scales: {
                    y: {
                        beginAtZero: true // Assure que l'axe Y commence à zéro
                    }
                }
            }
        });
    </script>
</x-app-layout>