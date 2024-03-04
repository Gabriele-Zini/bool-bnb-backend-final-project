@extends('layouts.app')

@section('content')
    <div class="container my-5">
        @if (session('message'))
            <div class=" text-center alert alert-success col-12 col-md-5 col-lg-4 m-auto my-3">
                {{ session('message') }}
            </div>
        @endif

        <div class="row g-5 justify-content-center">
            @if (count($apartments) > 0)
                @foreach ($apartments as $apartment)
                    <div class="col-12 col-md-5 col-lg-4 d-flex">
                        <div class="card my-shadow border-2 rounded-4 p-2">

                            {{-- first image --}}
                            @foreach ($apartment->images as $image)
                                <div class="h-100">
                                    @if ($image->cover_image == 1)
                                        <img class="apartment-image rounded-4 h-100"
                                            src="{{ asset('storage/image_path/' . $image->image_path) }}" alt="">
                                    @endif
                                </div>
                            @endforeach
                            {{-- end first image --}}

                            {{-- apartment infos --}}
                            <div class="card-body p-0">
                                <h5 class="card-title m-4 fs-5">{{ $apartment->title }}</h5>
                                <ul class="list-unstyled list-group list-group-flush border-0">
                                    <li class="list-group-item fs-6 my-0">
                                        <span class="fw-bold">Municipality:</span> {{ $apartment->city }}
                                    </li>
                                    <li class="list-group-item fs-6 my-0">
                                        <span class="fw-bold">Address:</span> {{ $apartment->street_name }},
                                        {{ $apartment->street_number }}
                                    </li>
                                    <li class="list-group-item fs-6 my-0">
                                        <span class="fw-bold">Postal code:</span> {{ $apartment->postal_code }}
                                    </li>
                                    <li class="list-group-item fs-6 my-0">
                                        @if ($apartment->visibility === 1)
                                            <p class=" my-0"><span class="fw-bold">Visibility: </span>on</p>
                                        @else
                                            <p class=" my-0"><span class="fw-bold">Visibility: </span>off</p>
                                        @endif
                                    </li>
                                </ul>
                            </div>

                            {{-- buttons --}}
                            <div class="card-body d-flex justify-content-center gap-2 align-items-center">
                                {{-- Dropdown button --}}
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
                                            <form class="d-flex"
                                                action="{{ route('apartments.destroy', ['apartment' => $apartment->slug]) }}"
                                                method="POST">
                                                @csrf
                                                @method('DELETE')
                                                <button type="submit" class="dropdown-item delete-btn"
                                                    data-bs-toggle="modal" data-title="{{ $apartment->title }}"
                                                    data-bs-target="#delete-modal">Delete</button>
                                            </form>
                                        </li>
                                        {{-- stats btn --}}
                                        <li>
                                            <a href="{{ route('views.show', ['apartment' => $apartment->slug]) }}"
                                                class="dropdown-item">Stats</a>
                                        </li>
                                        {{-- details btn --}}
                                        <li>
                                            <a href="{{ route('apartments.show', ['apartment' => $apartment->slug]) }}"
                                                class="dropdown-item">Details</a>
                                        </li>
                                    </ul>
                                </div>
                            </div>


                        </div>
                    </div>
                @endforeach
            @else
                <h3 class="text-center">You don't have any apartment</h3>
            @endif

        </div>

        {{-- modal --}}
        <div class="modal ms_font-color" tabindex="-1" id="delete-modal">
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
