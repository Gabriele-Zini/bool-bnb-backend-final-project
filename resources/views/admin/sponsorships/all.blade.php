@extends('layouts.app')

@section('content')
    {{-- @dd($groupedResult) --}}
    <div class="container w-100 mt-5">
        @foreach ($groupedResult as $key => $result)
            <div class="card my-5 px-4 ms_bg-card shadow">
                <h4 class="text-center my-4"><strong>{{ $key }}</strong>
                        <a
                        href="{{ route('sponsorships.index', ['apartment' => $result[0]->slug]) }}"
                        class="btn btn-info my-btn-blue ms-4">Details</a></h4>
                <div class="row justify-content-center">
                    @foreach ($result as $item)
                        <div class="col-12 col-md-6 col-lg-4 mb-4">
                            <div class="card ms_bg-small-card shadow" style="min-height: 183px;">
                                <div class="card-body">
                                    <h4 class="card-title fw-semibold ms_font-color">{{ ucfirst($item->name) }}</h4>
                                    <p class="card-text card-text mt-3 mb-1"><strong class="me-1">From:</strong>
                                        {{ date('d/m/Y', strtotime($item->start_date)) }}</p>

                                    <p class="card-text"><strong class="me-1">To:</strong>
                                        {{ date('d/m/Y', strtotime($item->expiration_date)) }}</p>


                                    @if (round(strtotime($item->expiration_date) - time()) < 0)
                                        <span class=" card-text badge bg-danger">Expired</span>
                                    @elseif (round(strtotime($item->expiration_date) - time()) > 0)
                                        @if (round(strtotime($item->start_date) - time()) > 0)
                                            <span class="card-text badge bg-success">Not yet started</span>
                                        @else
                                            <span class="card-text badge bg-warning">Started</span>
                                        @endif
                                    @endif

                                </div>
                            </div>
                        </div>
                    @endforeach
                </div>
            </div>
        @endforeach

        @if ($unsponsoredApartments->count() > 0)
            <h4 class="my-4 class text-center">Apartments without Sponsorship</h4>
            <div class="row justify-content-center align-items-center">
                @foreach ($unsponsoredApartments as $apartment)
                    <div class="col-12 col-md-6 col-lg-4 mb-4">
                        <div class="alert ms_bg-color-sponsorships d-flex align-items-center gap-4"
                            style="min-height: 200px" role="alert">
                            <h4 class="text-center my-4 text-white"><strong>{{ $apartment->title }}</strong></h4>
                            <a class="btn btn-warning my-btn"
                                href="{{ route('sponsorships.index', ['apartment' => $apartment->slug]) }}">Purchase</a>
                        </div>
                    </div>
                @endforeach
            </div>
        @endif
    </div>
@endsection
