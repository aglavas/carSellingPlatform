<div class="mt-2 ml-2 mr-2">
    <div class="bg-white overflow-hidden shadow rounded-lg">
        <div class="px-4 py-5 sm:p-6">
            <dl>
                <h2 class="text-2xl font-bold leading-7 text-gray-900 sm:text-3xl sm:truncate text-center">
                    Used cars by brand (avg km and age)
                </h2>
                <div class="chart-container">
                    <div class="pie-chart-container">
                        <canvas id="bubble-chart-{{ $rand }}" width="2300" height="2000"></canvas>
                    </div>
                </div>
                <script type="text/javascript">
                    (function() {
                        let values = @json($values);

                        let id = "bubble-chart-{{ $rand }}"

                        new Chart(document.getElementById(id), {
                            type: 'bubble',
                            data: {
                                datasets: values
                            },
                            options: {
                                responsive:true,
                                title: {
                                    display: true,
                                    text: 'Predicted world population (millions) in 2050'
                                },
                                scales: {
                                    y: {
                                        title: {
                                            display: true,
                                            text: "Avg KM"
                                        }
                                    },
                                    x: {
                                        title: {
                                            display: true,
                                            text: "Age (Years)"
                                        }
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
