@if(\Illuminate\Support\Facades\Auth::user()->isAdmin())
    <div class="ml-3">
@else
    <div class="mr-3 mt-3">
@endif
    <div class="bg-white overflow-hidden shadow rounded-lg">
        <div class="px-4 py-5 sm:p-6">
            <dl>
                <h2 class="text-2xl font-bold leading-7 text-gray-900 sm:text-3xl sm:truncate text-center">
                    Used cars by brand
                </h2>
                <div class="chart-container">
                    <div class="pie-chart-container">
                        <canvas id="used-bar-chart-by-brand-{{ $rand }}" width="800" height="400"></canvas>
                    </div>
                </div>
                <script type="text/javascript">
                    (function() {
                        let labels = @json($brand);
                        let values = @json($values);
                        let color = @json($color);

                        let id = "used-bar-chart-by-brand-{{ $rand }}"

                        new Chart(document.getElementById(id), {
                            type: 'bar',
                            data: {
                                labels: labels,
                                datasets: [{
                                    backgroundColor: color,
                                    data: values
                                }]
                            },
                            options: {
                                responsive: true,
                                plugins: {
                                    legend: {
                                        display: false
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
