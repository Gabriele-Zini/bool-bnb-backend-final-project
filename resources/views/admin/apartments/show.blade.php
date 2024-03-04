@extends('layouts.app')

@section('content')
    <div class="container text-center my-5">
        @if (session('message'))
            <div class="alert alert-success col-12 col-md-5 col-lg-4 m-auto my-3">
                {{ session('message') }}
            </div>
        @endif

        <div class="card shadow ms_bg-card py-5 px-2">

            @foreach ($apartment->images as $image)
                @if ($image->cover_image)
                    <h4 class="text-center fs-2">Cover Image</h4>
                    <div class="d-flex justify-content-center mt-3 mb-5">
                        <img src="{{ asset('storage/image_path/' . $image->image_path) }}" alt=""
                            class="rounded col-12 col-md-6 col-lg-5">
                    </div>
                @endif
            @endforeach

            {{-- to the gallery --}}
            @if (count($apartment->images) > 0)
                <h4 class="text-center ">Gallery</h4>
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
                                        <button type="submit" class="">Delete</button>
                                    </form>
                                </div>
                            </div>


                        </div>
                    @endif
                @endforeach

            </div>
        </div>

        <div class="card ms_bg-card my-5 pb-5 px-3 shadow">
            <div class="col-12 col-md-6 mt-5 m-auto">
                <div class="card ms_bg-small-card shadow">
                    <div class="card-body">
                        <h4 class="card-title ms_font-color">{{ $apartment->title }}</h4>
                    </div>

                    <ul class="list-unstyled  list-group-flush">

                        {{-- apartment address --}}
                        <li class="list-group-item my-3">
                            <span class="fw-bold">Municipality:</span> {{ $apartment->city }}
                        </li>
                        <li class="list-group-item my-3">
                            <span class="fw-bold">Address:</span> {{ $apartment->street_name }},
                            {{ $apartment->street_number }}
                        </li>
                        <li class="list-group-item my-3">
                            <span class="fw-bold">Postal code:</span> {{ $apartment->postal_code }}
                        </li>
                        <li class="list-group-item my-3">
                            @if ($apartment->visibility === 1)
                                <p class="my-0"><span class="fw-bold">Visibility: </span>on</p>
                            @else
                                <p class="my-0"><span class="fw-bold">Visibility: </span>off</p>
                            @endif
                        </li>

                        {{-- services --}}
                        @if (count($apartment->services) > 0)
                            <li class="list-group-item my-3">
                                <span class="fw-bold">Services: </span>
                                @foreach ($apartment->services as $service)
                                    <span class="d-inline">{{ $service->name }}@if (!$loop->last)
                                            ,
                                        @endif
                                    </span>
                                @endforeach
                            </li>
                        @endif

                        {{-- apartment infos --}}
                        <li class="list-group-item my-3">
                            <span class="fw-bold">Num. rooms:</span> {{ $apartment->apartment_info->num_rooms }}
                        </li>
                        <li class="list-group-item my-3">
                            <span class="fw-bold">Num. beds:</span> {{ $apartment->apartment_info->num_beds }}
                        </li>
                        <li class="list-group-item my-3">
                            <span class="fw-bold">Num. bathrooms:</span> {{ $apartment->apartment_info->num_bathrooms }}
                        </li>
                        <li class="list-group-item my-3">
                            <span class="fw-bold">Meters square:</span> {{ $apartment->apartment_info->mt_square }}
                        </li>

                        {{-- apartment views --}}
                        <li class="list-group-item my-3">
                            <span class="fw-bold">Views:</span> {{ count($apartment->views) }}
                        </li>

                        {{-- apartment sponsorhip active --}}
                        <li class="list-group-item my-3">
                            <span class="fw-bold">Sponsorization:</span>
                            {{ $sponsorship_type === 0 ? 'No sponsorizations' : $sponsorship_type[0]->name }}
                        </li>
                        <li class="list-group-item my-3">
                            <span class="fw-bold">Expiration date:</span>
                            {{ $sponsorship_active[0]->expiration_date ?? 'No sponsorizations' }}
                        </li>

                        {{-- dropdown button --}}
                        <li class="list-group-item my-3 d-flex justify-content-center gap-2">
                            <div class="dropdown">
                                <button class="btn my-btn-blue dropdown-toggle" type="button" id="dropdownMenuButton"
                                    data-bs-toggle="dropdown" aria-expanded="false">
                                    Actions
                                </button>
                                <ul class="dropdown-menu" aria-labelledby="dropdownMenuButton">
                                    {{-- edit btn --}}
                                    <li>
                                        <a href="{{ route('apartments.edit', ['apartment' => $apartment->slug]) }}"
                                            class="dropdown-item">Edit</a>
                                    </li>
                                    {{-- show messages --}}
                                    <li>
                                        <a href="{{ route('messages.index', ['apartment' => $apartment->slug]) }}"
                                            class="dropdown-item">Messages</a>
                                    </li>
                                    {{-- sponsorships --}}
                                    <li>
                                        <a href="{{ route('sponsorships.index', ['apartment' => $apartment->slug]) }}"
                                            class="dropdown-item">Sponsorships</a>
                                    </li>
                                    {{-- delete btn --}}
                                    <li>
                                        <form action="{{ route('apartments.destroy', ['apartment' => $apartment->slug]) }}"
                                            method="POST">
                                            @csrf
                                            @method('DELETE')
                                            <button type="submit" class="dropdown-item delete-btn" data-bs-toggle="modal"
                                                data-title="{{ $apartment->title }}"
                                                data-bs-target="#delete-modal">Delete</button>
                                        </form>
                                    </li>
                                    {{-- stats --}}
                                    <li>
                                        <a href="{{ route('views.show', ['apartment' => $apartment->slug]) }}"
                                            class="dropdown-item">Stats</a>
                                    </li>
                                </ul>
                            </div>
                        </li>

                    </ul>
                </div>
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
