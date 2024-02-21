@extends('layouts.app')

@section('content')
    <div class="container text-center my-5">
        @if (session('message'))
            <div class="alert alert-success col-12 col-md-5 col-lg-4 m-auto my-3">
                {{ session('message') }}
            </div>
        @endif




        <div class="col-12 col-md-5 col-lg-3 m-auto">
            <div class="card w-100">


                {{-- caoursel --}}
                <div id="carouselExampleIndicators" class="carousel slide">
                    <div class="carousel-indicators">
                        <button type="button" data-bs-target="#carouselExampleIndicators" data-bs-slide-to="0" class="active"
                            aria-current="true" aria-label="Slide 1"></button>
                        <button type="button" data-bs-target="#carouselExampleIndicators" data-bs-slide-to="1"
                            aria-label="Slide 2"></button>
                        <button type="button" data-bs-target="#carouselExampleIndicators" data-bs-slide-to="2"
                            aria-label="Slide 3"></button>
                    </div>
                    <div class="carousel-inner ms_carousel">
                        @foreach ($apartment->images as $image)
                            <div class="carousel-item active">
                                <img class="apartment-image"
                                    src="{{ asset('storage/image_path/' . $apartment->slug . '/' . $image->image_path) }}"
                                    alt="">
                            </div>
                            <form action="{{ route('images.destroy', ['image'=>$image->id])}}" method="POST" enctype="multipart/form-data">
                                @csrf
                                @method('DELETE')
                                <button type="submit" class=" ms_trash">delete</button></form>
                        @endforeach
                    </div>

                </div>
                <button class="carousel-control-prev" type="button" data-bs-target="#carouselExampleIndicators"
                    data-bs-slide="prev">
                    <span class="carousel-control-prev-icon" aria-hidden="true"></span>
                    <span class="visually-hidden">Previous</span>
                </button>
                <button class="carousel-control-next" type="button" data-bs-target="#carouselExampleIndicators"
                    data-bs-slide="next">
                    <span class="carousel-control-next-icon" aria-hidden="true"></span>
                    <span class="visually-hidden">Next</span>
                </button>

                {{-- end caoursel --}}

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
                        <a href="{{ route('apartments.edit', ['apartment' => $apartment->slug]) }}"
                            class="btn btn-warning">edit</a>
                        <form class="d-inline"
                            action="{{ route('apartments.destroy', ['apartment' => $apartment->slug]) }}" method="POST">
                            @csrf
                            @method('DELETE')
                            <button type="submit" class="btn btn-danger delete-btn" data-bs-toggle="modal"
                                data-title={{ $apartment->title }} data-bs-target="#delete-modal">Delete</button>
                        </form>
                    </li>
                </ul>
            </div>

        </div>


        {{-- modal --}}
        <div class="modal" tabindex="-1" id="delete-modal">
            <div class="modal-dialog">
                <div class="modal-content">
                    <div class="modal-header">
                        <h5 class="modal-title fw-bold">Delete <span class="apartment-title"></span></h5>
                        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                    </div>
                    <div class="modal-body">
                        <p>Are you sure you want to delete <span class="apartment-title fw-bold"></span>?</p>
                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
                        <button id="confirm-delete" type="button" class="btn btn-danger">Confirm delete</button>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection
