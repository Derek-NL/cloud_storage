<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-2xl text-gray-800 leading-tight">
            {{ __('Cloud Storage Dashboard') }}
        </h2>
    </x-slot>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white overflow-hidden shadow-xl sm:rounded-lg p-6">
                <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                    <!-- Meest Geüploade Bestanden per Gebruiker -->
                    <div>
                        <h3 class="text-lg font-semibold">Meest Geüploade Bestanden per Gebruiker</h3>
                        <canvas id="mostUploadedFilesChart" width="400" height="400"></canvas>
                    </div>

                    <!-- Actieve Sessies -->
                    <div class="mb-6">
                        <h3 class="text-lg font-semibold">Actieve Sessies</h3>
                        <p>Aantal actieve sessies: <strong>{{ $activeSessions }}</strong></p>
                    </div>
                </div>

                <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                    <!-- Bestandstype Verdeling -->
                    <div>
                        <h3 class="text-lg font-semibold">Bestandstype Verdeling</h3>
                        <canvas id="fileTypeDistributionChart" width="400" height="400"></canvas>
                    </div>

                    <!-- Aantal Bestanden per Extensie -->
                    <div>
                        <h3 class="text-lg font-semibold">Aantal Bestanden per Extensie</h3>
                        <p>PNG: <strong>{{ $fileCounts->png_count }}</strong></p>
                        <p>JPG/JPEG: <strong>{{ $fileCounts->jpg_count }}</strong></p>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
    <script>
        // Meest Geüploade Bestanden per Gebruiker
        const mostUploadedFilesCtx = document.getElementById('mostUploadedFilesChart').getContext('2d');
        const mostUploadedFilesChart = new Chart(mostUploadedFilesCtx, {
            type: 'bar',
            data: {
                labels: @json($mostUploadedFiles->pluck('user_id')),
                datasets: [{
                    label: 'Aantal Uploads',
                    data: @json($mostUploadedFiles->pluck('total_uploads')),
                    backgroundColor: '#42A5F5',
                }]
            },
            options: {
                scales: {
                    y: {
                        beginAtZero: true
                    }
                }
            }
        });

        // Bestandstype Verdeling (voorbeelddata, je kunt dit vervangen door echte data)
        const fileTypeDistributionCtx = document.getElementById('fileTypeDistributionChart').getContext('2d');
        const fileTypeDistributionChart = new Chart(fileTypeDistributionCtx, {
            type: 'pie',
            data: {
                labels: ['PNG', 'JPG/JPEG'], // Labels voor de bestandstypen
                datasets: [{
                    label: 'Bestandstype Verdeling',
                    data: [
                        {{ $fileCounts->png_count }}, 
                        {{ $fileCounts->jpg_count }}
                    ],
                    backgroundColor: ['#FF6384', '#36A2EB'],
                }]
            }
        });
    </script>
</x-app-layout>
