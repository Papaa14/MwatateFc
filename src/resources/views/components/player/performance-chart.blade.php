<div class="p-6 bg-white rounded-lg shadow">
    <div class="flex items-center justify-between mb-6">
        <h3 class="text-lg font-medium text-gray-900">Performance Trend</h3>
        <div class="relative">
            <select class="block w-full pl-3 pr-10 py-2 text-base border-gray-300 focus:outline-none focus:ring-blue-500 focus:border-blue-500 sm:text-sm rounded-md">
                <option>Last 7 Days</option>
                <option selected>Last 30 Days</option>
                <option>This Season</option>
            </select>
        </div>
    </div>
    
    <div class="h-64">
        <canvas id="performanceChart"></canvas>
    </div>
    
    <div class="grid grid-cols-4 gap-4 mt-6 text-center">
        <div class="p-3 bg-gray-50 rounded-lg">
            <p class="text-sm font-medium text-gray-500">Average Rating</p>
            <p class="text-xl font-bold text-blue-600">{{ $averageRating }}</p>
        </div>
        <div class="p-3 bg-gray-50 rounded-lg">
            <p class="text-sm font-medium text-gray-500">Peak Rating</p>
            <p class="text-xl font-bold text-green-600">{{ $peakRating }}</p>
        </div>
        <div class="p-3 bg-gray-50 rounded-lg">
            <p class="text-sm font-medium text-gray-500">Consistency</p>
            <p class="text-xl font-bold text-yellow-600">{{ $consistency }}%</p>
        </div>
        <div class="p-3 bg-gray-50 rounded-lg">
            <p class="text-sm font-medium text-gray-500">Improvement</p>
            <p class="text-xl font-bold {{ $improvement >= 0 ? 'text-green-600' : 'text-red-600' }}">
                {{ $improvement >= 0 ? '+' : '' }}{{ $improvement }}%
            </p>
        </div>
    </div>
</div>

@push('scripts')
<script>
    document.addEventListener('DOMContentLoaded', function() {
        const ctx = document.getElementById('performanceChart').getContext('2d');
        const chart = new Chart(ctx, {
            type: 'line',
            data: {
                labels: {!! json_encode($labels) !!},
                datasets: [{
                    label: 'Performance Rating',
                    data: {!! json_encode($data) !!},
                    backgroundColor: 'rgba(59, 130, 246, 0.05)',
                    borderColor: 'rgba(59, 130, 246, 1)',
                    borderWidth: 2,
                    tension: 0.4,
                    fill: true,
                    pointBackgroundColor: 'rgba(59, 130, 246, 1)',
                    pointRadius: 4,
                    pointHoverRadius: 6
                }]
            },
            options: {
                responsive: true,
                maintainAspectRatio: false,
                scales: {
                    y: {
                        beginAtZero: false,
                        min: 5,
                        max: 10,
                        ticks: {
                            stepSize: 1
                        }
                    }
                },
                plugins: {
                    tooltip: {
                        callbacks: {
                            label: function(context) {
                                return 'Rating: ' + context.parsed.y.toFixed(1);
                            }
                        }
                    },
                    legend: {
                        display: false
                    }
                }
            }
        });
    });
</script>
@endpush