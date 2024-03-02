@extends('layouts.app')

@section('content')
    {{-- @dd($groupedResult) --}}
    <div class="container w-100 mt-5">
        @foreach ($groupedResult as $key => $result)
            <div class="card my-5 px-4 ms_bg-card shadow">
                <h4 class="text-center my-4"><strong>{{ $key }}</strong></h4>
                <div class="row justify-content-center">
                    @foreach ($result as $item)
                        <div class="col-12 col-md-6 col-lg-4 mb-4">
                            <div class="card ms_bg-small-card shadow">
                                <div class="card-body">
                                    <h5 class="card-title">{{ ucfirst($item->name) }}</h5>
                                    <p class="card-text">Status:
                                        @if (round(strtotime($item->expiration_date) - time()) < 0)
                                            <span class="badge bg-danger">Expired</span>
                                        @elseif (round(strtotime($item->expiration_date) - time()) > 0)
                                            @if (round(strtotime($item->start_date) - time()) > 0)
                                                <span class="badge bg-success">Not yet started</span>
                                            @else
                                                <span class="badge bg-warning">Started</span>
                                            @endif
                                        @endif
                                    </p>
                                    <p class="card-text">Start Date: {{ date('d/m/Y', strtotime($item->start_date)) }}</p>
                                    <p class="card-text">Expiration Date:
                                        {{ date('d/m/Y', strtotime($item->expiration_date)) }}</p>
                                    <a href="{{ route('sponsorships.index', ['apartment' => $item->slug]) }}"
                                        class="btn btn-warning">Purchase</a>
                                </div>
                            </div>
                        </div>
                    @endforeach
                </div>
            </div>
        @endforeach

        @if ($unsponsoredApartments->count() > 0)
            <h4 class="my-4 class text-center">Apartments without Sponsorship</h4>
            <div class="row justify-content-center">
                @foreach ($unsponsoredApartments as $apartment)
                    <div class="col-12 col-md-6 col-lg-4 mb-4">
                        <div class="alert ms_bg-color-sponsorships d-flex align-items-center gap-4 " role="alert">
                            <h4 class="text-center my-4 text-white"><strong>{{ $apartment->title }}</strong></h4>
                            <a class="btn btn-warning"
                                href="{{ route('sponsorships.index', ['apartment' => $apartment->slug]) }}">Purchase</a>
                        </div>
                    </div>
                @endforeach
            </div>
        @endif
    </div>
@endsection
