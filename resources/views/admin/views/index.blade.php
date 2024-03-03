@extends('layouts.app')

@section('content')
    <script src="
                    https://cdn.jsdelivr.net/npm/chart.js@4.4.2/dist/chart.umd.min.js
                    "></script>
    <script type="module" src="acquisitions.js"></script>

    <h4 class="text-center mt-4">Views by apartment</h4>


    <div class="d-flex justify-content-center">
        <div class="col-12 col-md-10 col-lg-5 my-5""><canvas id="acquisitions"></canvas></div>
    </div>
    <script>
        document.addEventListener('DOMContentLoaded', function() {
            const views = {!! $views !!};

            const groupedData = [];
            let totalViews = 0;

            views.forEach(view => {
                const apartmentId = view.apartment_id;
                const apartmentName = view.apartment_title;

                const existingApartmentIndex = groupedData.findIndex(item => item.apartmentName ===
                    apartmentName);

                if (existingApartmentIndex !== -1) {
                    groupedData[existingApartmentIndex].count += 1;
                } else {
                    groupedData.push({
                        apartmentName,
                        count: 1
                    });
                }
                totalViews++;
            });
            Chart.defaults.font.size = 12;
            new Chart(
    document.getElementById('acquisitions'), {
        type: 'doughnut',
        data: {
            labels: ['Total Views', ...groupedData.map(row => row.apartmentName)],
            datasets: [{
                label: 'Total views',
                data: [totalViews, ...groupedData.map(row => row.count)],
                borderWidth: 1
            }],
        },
    }
);



        });
    </script>
@endsection
