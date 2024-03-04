@extends('layouts.app')

@section('content')
    <script src="
    https://cdn.jsdelivr.net/npm/chart.js@4.4.2/dist/chart.umd.min.js
    "></script>
    <script type="module" src="acquisitions.js"></script>

    <h4 class="text-center mt-4">Views of {{ $apartment->title }}</h4>

    <div class="d-flex justify-content-center">
        <div class="col-12 col-md-10 my-5""><canvas id="acquisitions"></canvas></div>
    </div>
    <script>
        document.addEventListener('DOMContentLoaded', function() {
            const views = {!! $views !!};
            const last7Days = [];
            for (let i = 6; i >= 0; i--) {
                const date = new Date();
                date.setDate(date.getDate() - i);
                last7Days.push(date.toISOString().split('T')[0]);
            }
            const groupedData = {};
            last7Days.forEach(day => {
                groupedData[day] = 0;
            });
            views.forEach(view => {
                const createdAt = new Date(view.created_at).toISOString().split('T')[0];
                if (groupedData.hasOwnProperty(createdAt)) {
                    groupedData[createdAt]++;
                }
            });
            const labels = last7Days;
            const data = Object.values(groupedData);
            new Chart(
                document.getElementById('acquisitions'), {
                    type: 'line',
                    data: {
                        labels: labels,
                        datasets: [{
                            label: 'Views',
                            data: data,
                            borderColor: 'rgb(75, 192, 192)',
                            tension: 0.4,
                            fill: false
                        }]
                    },
                    options: {
                        scales: {
                            y: {
                                ticks: {
                                    stepSize: 1,
                                }
                            }
                        }
                    },
                    plugins: {
                        tooltip: {
                            enabled: true,
                            callbacks: {
                                label: function(context) {
                                    return context.dataset.label + ': ' + context.parsed.y;
                                }
                            }
                        }
                    }
                }
            );
        });
    </script>
@endsection
