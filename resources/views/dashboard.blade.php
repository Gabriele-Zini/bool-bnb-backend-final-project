<x-app-layout>
    <div class="py-12 d-flex flex-column align-items-center container">

        {{--  <div class="card ms_bg-card d-flex justify-content-center fw-bold ms_font-color p-4 shadow" style="height: 100px">
            {{ Auth::user()->name }} {{ Auth::user()->lastname }} {{ __("you're logged in!") }}
        </div> --}}

        <div class="container mt-5">
            <div class="row g-5 justify-content-center align-items-center">

                <div class="col-12 col-sm-6 col-lg-4">
                    <a class="ms_font-anchor" href="{{ route('apartments.index') }}">
                        <div class="ms_border border-0 card shadow d-flex align-items-center  justify-content-around mx-auto pb-5 pt-3"
                            style="aspect-ratio: 1/1; background-color:#0000">

                            <div class="ms_dashboard-avatar ms_bg-card mb-3">
                                <i class="fa-solid fa-building ms_icon-avatar"
                                    style="display: flex; justify-content: center; align-items: center; height: 100%;"></i>
                            </div>

                            <div class="car  d-flex align-items-center justify-content-center"
                                style="width: 80%; height: 30%">
                                <a class="ms_font-anchor fs-4" href="{{ route('apartments.index') }}">Apartments</a>

                            </div>
                        </div>
                    </a>
                </div>
                <div class="col-12 col-sm-6 col-lg-4">
                    <a class="ms_font-anchor fs-4" href="{{ route('all_messages') }}">
                        <div class="ms_border border-0 card  shadow d-flex align-items-center  justify-content-around mx-auto pb-5 pt-3"
                            style="aspect-ratio: 1/1; background-color:#0000">

                            <div class="ms_dashboard-avatar ms_bg-card mb-3">
                                <i class="fa-solid fa-envelope ms_icon-avatar"
                                    style="display: flex; justify-content: center; align-items: center; height: 100%;"></i>
                            </div>

                            <div class="car d-flex align-items-center justify-content-center"
                                style="width: 80%; height: 30%">
                                <a class="ms_font-anchor fs-4" href="{{ route('all_messages') }}">Messages</a>

                            </div>
                        </div>
                    </a>
                </div>
                <div class="col-12 col-sm-6 col-lg-4">
                    <a class="ms_font-anchor fs-4" href="{{ route('apartments.create') }}">
                        <div class="ms_border border-0 card  shadow d-flex align-items-center  justify-content-around mx-auto pb-5 pt-3"
                            style="aspect-ratio: 1/1; background-color:#0000">

                            <div class="ms_dashboard-avatar ms_bg-card mb-3 shadow">
                                <i class="fa-solid fa-hammer ms_icon-avatar"
                                    style="display: flex; justify-content: center; align-items: center; height: 100%;"></i>
                            </div>

                            <div class="car d-flex align-items-center justify-content-center"
                                style="width: 80%; height: 30%">
                                <a class="ms_font-anchor fs-4" href="{{ route('apartments.create') }}">New Apartment</a>

                            </div>
                        </div>
                    </a>
                </div>
                <div class="col-12 col-sm-6 col-lg-4">
                    <a class="ms_font-anchor fs-4" href="{{ route('all_sponsorships') }}">
                        <div class="ms_border border-0 card  shadow d-flex align-items-center  justify-content-around mx-auto pb-5 pt-3"
                            style="aspect-ratio: 1/1; background-color:#0000">

                            <div class="ms_dashboard-avatar ms_bg-card mb-3 shadow">
                                <i class="fa-solid fa-coins ms_icon-avatar"
                                    style="display: flex; justify-content: center; align-items: center; height: 100%;"></i>
                            </div>

                            <div class="car d-flex align-items-center justify-content-center"
                                style="width: 80%; height: 30%">
                                <a class="ms_font-anchor fs-4" href="{{ route('all_sponsorships') }}">Sponsorization</a>

                            </div>
                        </div>
                    </a>
                </div>
                <div class="col-12 col-sm-6 col-lg-4">
                    <a class="ms_font-anchor fs-4" href="{{ route('views.index') }}">
                        <div class="ms_border border-0 card  shadow d-flex align-items-center  justify-content-around mx-auto pb-5 pt-3"
                            style="aspect-ratio: 1/1; background-color:#0000">

                            <div class="ms_dashboard-avatar ms_bg-card mb-3 shadow">
                                <i class="fa-solid fa-chart-simple ms_icon-avatar"
                                    style="display: flex; justify-content: center; align-items: center; height: 100%;"></i>
                            </div>

                            <div class="car d-flex align-items-center justify-content-center"
                                style="width: 80%; height: 30%">
                                <a class="ms_font-anchor fs-4" href="{{ route('views.index') }}">Your Stats</a>

                            </div>
                        </div>
                    </a>
                </div>
                <div class="col-12 col-sm-6 col-lg-4">
                    <a class="ms_font-anchor fs-4" href="{{ route('profile.edit') }}">
                        <div class="ms_border border-0 card  shadow d-flex align-items-center  justify-content-around mx-auto pb-5 pt-3"
                            style="aspect-ratio: 1/1; background-color:#0000">

                            <div class="ms_dashboard-avatar ms_bg-card mb-3 shadow">
                                <i class="fa-solid fa-user ms_icon-avatar"
                                    style="display: flex; justify-content: center; align-items: center; height: 100%;"></i>
                            </div>

                            <div class="car d-flex align-items-center justify-content-center"
                                style="width: 80%; height: 30%">
                                <a class="ms_font-anchor fs-4" href="{{ route('profile.edit') }}">Your Profile</a>

                            </div>
                        </div>
                    </a>
                </div>

            </div>
        </div>
    </div>
    <style>
        .ms_dashboard-avatar {
            border-radius: 50%;
            width: 130px;
            height: 130px;
            border: 1px solid #52a3c0;
        }
        .ms_dashboard-avatar:hover {
            background-color: white;
        }

        .ms_icon-avatar {
            font-size: 3rem;
            color: #52a3c0
        }

        .ms_font-anchor {
            color: #52a3c0;
            font-size: 1.5rem;
            font-weight: bold;
            text-decoration: none;
        }
        .ms_border:hover {
            border: 1px solid #52a3c0!important;
        }
    </style>
</x-app-layout>
