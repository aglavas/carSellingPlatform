<div class="ml-3">
    <div class="bg-white overflow-hidden shadow rounded-lg">
        <div class="px-4 py-5 sm:p-6">
            <dl>
                <h2 class="text-2xl font-bold leading-7 text-gray-900 sm:text-3xl sm:truncate text-center">
                    Used cars by fuel
                </h2>
                <div class="chart-container">
                    <div class="doughnut-chart-container">
                        <canvas id="doughnut-chart-by-fuel-{{ $rand }}" width="800" height="400"></canvas>
                    </div>
                </div>
                <script type="text/javascript">
                    (function() {
                        let labels = @json($fuel);
                        let values = @json($values);
                        let colors = @json($color);

                        let id = "doughnut-chart-by-fuel-{{ $rand }}"

                        new Chart(document.getElementById(id), {
                            type: 'doughnut',
                            data: {
                                labels: labels,
                                datasets: [
                                    {
                                        label: "Used cars by fuel",
                                        backgroundColor: colors,
                                        data: values
                                    }
                                ]
                            },
                            options: {
                                responsive: true,
                                title: {
                                    display: true,
                                    text: 'Used cars by fuel'
                                }
                            }
                        });
                    })();
                </script>
            </dl>
        </div>
    </div>
</div>
