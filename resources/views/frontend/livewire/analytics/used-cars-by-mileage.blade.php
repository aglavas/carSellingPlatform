<div class="ml-3">
    <div class="bg-white overflow-hidden shadow rounded-lg">
        <div class="px-4 py-5 sm:p-6">
            <dl>
                <h2 class="text-2xl font-bold leading-7 text-gray-900 sm:text-3xl sm:truncate text-center">
                    Used cars by average mileage
                </h2>
                <div class="chart-container">
                    <div class="bar-chart-container">
                        <canvas id="bar-chart-by-mileage-{{ $rand }}" width="800" height="400"></canvas>
                    </div>
                </div>
                <script type="text/javascript">
                    (function() {
                        let labels = @json($age);
                        let values = @json($values);
                        let colors = @json($color);

                        let id = "bar-chart-by-mileage-{{ $rand }}"

                        new Chart(document.getElementById(id), {
                            type: 'bar',
                            data: {
                                labels: labels,
                                datasets: [
                                    {
                                        label: "Used cars by mileage",
                                        backgroundColor: colors,
                                        data: values
                                    }
                                ]
                            },
                            options: {
                                responsive: true,
                                plugins: {
                                    legend: {
                                        display: false,
                                    }
                                }
                            }
                        });
                    })();
                </script>
            </dl>
        </div>
    </div>
</div>
