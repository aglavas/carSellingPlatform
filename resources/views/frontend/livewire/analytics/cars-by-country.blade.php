<div class="ml-3 mt-3">
    <div class="bg-white overflow-hidden shadow rounded-lg">
        <div class="px-4 py-5 sm:p-6">
            <dl>
                <h2 class="text-2xl font-bold leading-7 text-gray-900 sm:text-3xl sm:truncate text-center">
                    Cars per country
                </h2>
                <div class="chart-container">
                    <div class="pie-chart-container">
                        <canvas id="bar-chart-cars-by-country-{{ $rand }}" width="800" height="400"></canvas>
                    </div>
                </div>
                <script type="text/javascript">
                    (function() {
                        let labels = @json($countries);
                        let values = @json($values);

                        let id = "bar-chart-cars-by-country-{{ $rand }}"

                        new Chart(document.getElementById(id), {
                            type: 'bar',
                            data: {
                                labels: labels,
                                datasets: values
                            },
                            options: {
                                title: {
                                    display: true,
                                    text: 'Population growth (millions)'
                                }
                            }
                        });
                    })();
                </script>
            </dl>
        </div>
    </div>
</div>
