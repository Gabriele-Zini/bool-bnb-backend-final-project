@extends('layouts.app')

@section('content')
    <div class="container text-center">

        <div class="col-12 col-md-5 col-lg-3 m-auto">
            <div class="card" style="width: 18rem;">
                {{-- <img src="..." class="card-img-top" alt="..."> --}}
                <div class="card-body">
                    <h5 class="card-title">{{ $apartment->title }}</h5>
                </div>
                <ul class="list-unstyled list-group list-group-flush">
                    <li class="list-group-item">
                        <span class="fw-bold">Description:</span> {{ $apartment->title }}
                    </li>
                    <li class="list-group-item">
                        <span class="fw-bold">Municipality:</span> {{ $apartment->city }}
                    </li>
                    <li class="list-group-item">
                        <span class="fw-bold">Address:</span> {{ $apartment->street_name }},
                        {{ $apartment->street_number }}
                    </li>
                    <li class="list-group-item">
                        <span class="fw-bold">Postal code:</span> {{ $apartment->postal_code }}
                    </li>
                    <li class="list-group-item">
                        @if ($apartment->visibility === 1)
                            <p class=" my-0"><span class="fw-bold">Visibility: </span>on</p>
                        @else
                            <p class=" my-0"><span class="fw-bold">Visibility: </span>off</p>
                        @endif
                    </li>

                    @if (count($apartment->services) > 0)
                        <li class="list-group-item">
                            <span class="fw-bold">Services: </span>
                            @foreach ($apartment->services as $service)
                                <p class="d-inline">{{ $service->name }}@if ($loop->last)
                                    . @else,
                                    @endif
                                </p>
                            @endforeach
                        </li>
                    @endif

                    {{-- @dd($apartment->apartment_info->num_beds) --}}
                    {{-- @foreach ($apartment->apartment_info as $info)
                        <li class="list-group-item">
                            <span class="fw-bold">Num {{ $info->num_rooms }}:</span>
                        </li>
                    @endforeach --}}

                    <li class="list-group-item">
                        <span class="fw-bold">Num. rooms:</span> {{ $apartment->apartment_info->num_rooms }}
                    </li>

                    <li class="list-group-item">
                        <span class="fw-bold">Num. beds:</span> {{ $apartment->apartment_info->num_beds }}
                    </li>

                    <li class="list-group-item">
                        <span class="fw-bold">Num. bathrooms:</span> {{ $apartment->apartment_info->num_bathrooms }}
                    </li>

                    <li class="list-group-item">
                        <span class="fw-bold">Meters square :</span> {{ $apartment->apartment_info->mt_square }}
                    </li>

                    <li class="list-group-item">
                        <a href="{{ route('apartments.edit', ['apartment' => $apartment->slug]) }}" class="btn btn-warning">edit</a>
                    </li>

                    <li class="list-group-item">
                        <a href="#" class="btn btn-danger">delete</a>
                    </li>
                </ul>
            </div>
        </div>

    </div>
@endsection
