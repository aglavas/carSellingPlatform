<div class="mr-3">
    <div class="bg-white overflow-hidden shadow rounded-lg">
        <div class="px-4 py-5 sm:p-6">
            <dl>
                <h2 class="text-2xl font-bold leading-7 text-gray-900 sm:text-3xl sm:truncate text-center">
                    PCD by country
                </h2>
                <div class="chart-container">
                    <div class="pie-chart-container">
                        <canvas id="bar-chart-pcd-by-country-{{ $rand }}" width="800" height="400"></canvas>
                    </div>
                </div>
                <script type="text/javascript">
                    (function() {
                        let labels = @json($countries);
                        let brandValues = @json($values);
                        let brandColors = @json($color);

                        let id = "bar-chart-pcd-by-country-{{ $rand }}"

                        new Chart(document.getElementById(id), {
                            type: 'bar',
                            data: {
                                labels: labels,
                                datasets: [{
                                    label: "PCD by country Bar",
                                    backgroundColor: brandColors,
                                    data: brandValues
                                }]
                            },
                            options: {
                                responsive: true,
                                plugins: {
                                    legend: {
                                        display: false
                                    }
                                },
                                title: {
                                    display: true,
                                    text: 'PCD by country Bar'
                                }
                            }
                        });
                    })();
                </script>
            </dl>
        </div>
    </div>
</div>
