<div class="mb-5">
    <div class="bg-white overflow-hidden shadow rounded-lg">
        <div class="px-4 py-5 sm:p-6">
            <dl>
                <h2 class="text-2xl font-bold leading-7 text-gray-900 sm:text-3xl sm:truncate text-center">
                    Used cars by avg and median mileage
                </h2>
                <div class="chart-container">
                    <div class="bar-chart-container">
                        <canvas id="bar-chart-by-avg-median-mileage-{{ $rand }}" width="800" height="400"></canvas>
                    </div>
                </div>
                <script type="text/javascript">
                    (function() {
                        let labels = @json($age);
                        let avgValues = @json($values);
                        let medianValues = @json($median);
                        let colors = @json($color);

                        let id = "bar-chart-by-avg-median-mileage-{{ $rand }}"

                        new Chart(document.getElementById(id), {
                            type: 'line',
                            data: {
                                labels: labels,
                                datasets: [
                                    {
                                        type: 'bar',
                                        label: "Used cars by avg mileage",
                                        backgroundColor: colors,
                                        data: avgValues
                                    },
                                    {
                                        type: 'line',
                                        label: "Used cars by median mileage",
                                        borderColor: 'Green',
                                        fill: false,
                                        backgroundColor: colors,
                                        data: medianValues
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
