@extends('layouts.app')

@section('content')
    <div class="container my-5">
        <h1 class="my-4 text-center">Apartments list</h1>
        <div class="row g-5 justify-content-center">
            @foreach ($apartments as $apartment)
                <div class="col-12 col-md-5 col-lg-3">
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

                        </ul>
                        <div class="card-body ">
                            <a href="#" class="btn btn-warning">edit</a>
                            <a href="#" class="btn btn-danger">delete</a>
                        </div>
                    </div>
                </div>
            @endforeach
        </div>
    </div>
@endsection
