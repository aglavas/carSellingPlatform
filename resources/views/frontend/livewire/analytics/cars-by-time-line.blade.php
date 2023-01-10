<div class="ml-3">
    <div class="bg-white overflow-hidden shadow rounded-lg">
        <div class="px-4 py-5 sm:p-6">
            <dl>
                <h2 class="text-2xl font-bold leading-7 text-gray-900 sm:text-3xl sm:truncate text-center">
                    Number of cars over time
                </h2>
                <div class="chart-container">
                    <div class="pie-chart-container">
                        <canvas id="line-chart-cars-by-time-{{ $rand }}" width="800" height="400"></canvas>
                    </div>
                </div>
                <script type="text/javascript">
                    (function() {
                        let labels = @json($time);
                        let values = @json($values);

                        let id = "line-chart-cars-by-time-{{ $rand }}"

                        new Chart(document.getElementById(id), {
                            type: 'line',
                            data: {
                                labels: labels,
                                datasets: values
                            },
                            options: {
                                responsive: true,
                                title: {
                                    display: true,
                                    text: 'Number of cars over time'
                                }
                            }
                        });
                    })();
                </script>
            </dl>
        </div>
    </div>
</div>
