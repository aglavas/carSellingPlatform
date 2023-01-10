<div class="mt-3">
    <div class="bg-white overflow-hidden shadow rounded-lg">
        <div class="px-4 py-5 sm:p-6">
            <dl>
                <h2 class="text-2xl font-bold leading-7 text-gray-900 sm:text-3xl sm:truncate text-center">
                    Used cars by brand
                </h2>
                <div class="chart-container">
                    <div class="pie-chart-container">
                        <canvas id="pie-chart-by-brand-{{ $rand }}" width="800" height="400"></canvas>
                    </div>
                </div>
                <script type="text/javascript">
                    (function() {
                        let labels = @json($brand);
                        let values = @json($values);
                        let color = @json($color);

                        let id = "pie-chart-by-brand-{{ $rand }}"

                        new Chart(document.getElementById(id), {
                            type: 'pie',
                            data: {
                                labels: labels,
                                datasets: [{
                                    label: "Used cars by brand",
                                    backgroundColor: color,
                                    data: values
                                }]
                            },
                            options: {
                                responsive: true,
                                title: {
                                    display: true,
                                    text: 'Used cars by brand'
                                }
                            }
                        });
                    })();
                </script>
            </dl>
        </div>
    </div>
</div>
