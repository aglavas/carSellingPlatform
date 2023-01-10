<div class="ml-3">
    <div class="bg-white overflow-hidden shadow rounded-lg">
        <div class="px-4 py-5 sm:p-6">
            <dl>
                <h2 class="text-2xl font-bold leading-7 text-gray-900 sm:text-3xl sm:truncate text-center">
                    Used cars by age (combined)
                </h2>
                <div class="chart-container">
                    <div class="bar-chart-container">
                        <canvas id="bar-chart-combined-{{ $rand }}" width="800" height="400"></canvas>
                    </div>
                </div>
                <script type="text/javascript">
                    (function() {
                        let labels = @json($age);
                        let numberValues = @json($countValues);
                        let mileageValues = @json($kmValues);
                        let priceValues = @json($priceValues);
                        let colors = @json($color);

                        let id = "bar-chart-combined-{{ $rand }}"

                        new Chart(document.getElementById(id), {
                            type: 'bar',
                            data: {
                                labels: labels,
                                datasets: [
                                    {
                                        label: "Number of used cars by age",
                                        backgroundColor: colors,
                                        data: numberValues
                                    },
                                    {
                                        label: "Mileage of used cars by age",
                                        backgroundColor: colors,
                                        data: mileageValues
                                    },
                                    {
                                        label: "Price of used cars by age",
                                        backgroundColor: colors,
                                        data: priceValues
                                    },
                                ]
                            },
                            options: {
                                responsive: true,
                                title: {
                                    display: true,
                                    text: 'Used cars by age (combined)'
                                }
                            }
                        });
                    })();
                </script>
            </dl>
        </div>
    </div>
</div>
