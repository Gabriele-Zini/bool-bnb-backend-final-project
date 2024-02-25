@extends('layouts.app')

@section('content')
    <div class="container text-center my-5">
        @if (session('message'))
            <div class="alert alert-success col-12 col-md-5 col-lg-4 m-auto my-3">
                {{ session('message') }}
            </div>
        @endif



        @foreach ($apartment->images as $image)
            @if ($image->cover_image)
                <h3 class="text-center title-link">Cover Image</h3>
                <div class="d-flex justify-content-center mt-3 mb-5">
                    <img src="{{ asset('storage/image_path/' . $image->image_path) }}" alt=""
                        class="rounded col-12 col-md-6 col-lg-5">
                </div>
            @endif
        @endforeach

        {{-- to the gallery --}}
        @if (count($apartment->images) > 0)
            <h4 class="title-link ">Gallery</h4>
        @endif


        <div class="d-flex flex-wrap justify-content-center align-items-center gap-3 mt-3">
            @foreach ($apartment->images as $image)
                @if (!$image->cover_image)
                    <div class="image-controller-container">
                        <img src="{{ asset('storage/image_path/' . $image->image_path) }}" alt=""
                            class="rounded ms_img-index">


                        <div class="popover">
                            <i class="fas fa-ellipsis-h popover-icon"></i>
                            <div class="popover-content d-none">

                                <form action="{{ route('images.update', ['image' => $image->id]) }}" method="POST"
                                    enctype="multipart/form-data">
                                    @csrf
                                    @method('PUT')
                                    <button type="submit">Set as cover image</button>
                                </form>
                                <form action="{{ route('images.destroy', ['image' => $image->id]) }}" method="POST"
                                    enctype="multipart/form-data">
                                    @csrf
                                    @method('DELETE')
                                    <button type="submit">Delete</button>
                                </form>
                            </div>
                        </div>


                    </div>
                @endif
            @endforeach

        </div>

        {{-- card info --}}
        <div class="col-12 col-md-6 mt-5  m-auto">
            <div class="card w-100">
                <div class="card-body">
                    <h5 class="card-title">{{ $apartment->title }}</h5>
                </div>

                <ul class="list-unstyled list-group list-group-flush">

                    {{-- apartment address --}}
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

                    {{-- services --}}
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

                    {{-- apartment infos --}}
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
                        <span class="fw-bold">Meters square:</span> {{ $apartment->apartment_info->mt_square }}
                    </li>

                    {{-- apartment views --}}
                    <li class="list-group-item">
                        <span class="fw-bold">Views:</span> {{ count($apartment->views) }}
                    </li>

                    {{-- apartment sponsorhip active --}}
                    {{-- @foreach ($apartment->sponsorships as $sponsorship)
                        <li class="list-group-item">
                            <span class="fw-bold">Sponsorship:</span>
                            {{ $sponsorship->name }}
                        </li>
                    @endforeach --}}
                    <li class="list-group-item">
                        <span class="fw-bold">Expiration date:</span>
                        {{ $sponsorship_type === 0 ? 'No sponsorizations' : $sponsorship_type[0]->name }}
                    </li>

                    <li class="list-group-item">
                        <span class="fw-bold">Expiration date:</span>
                        {{ $sponsorship_active[0]->expiration_date ?? 'No sponsorizations' }}
                    </li>

                    {{-- buttons --}}
                    <li class="list-group-item">

                        {{-- edit btn --}}
                        <a href="{{ route('apartments.edit', ['apartment' => $apartment->slug]) }}"
                            class="btn btn-warning">edit
                        </a>
                        {{-- show messages --}}
                        <a href="{{ route('messages.index', ['apartment' => $apartment->slug]) }}"
                            class="btn btn-warning">Messages
                        </a>

                        {{-- delete btn --}}
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
