@extends('layouts.app')

@section('content')
    <div class="container my-5">

        @if (session('message'))
            <div class="alert alert-success col-12 col-md-10 col-lg-9 col-xl-8 m-auto my-3">
                {{ session('message') }}
            </div>
        @endif
        <div class="card shadow p-5 ms_bg-card ">
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
                <h4 class="text-center">Gallery</h4>
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

        </div>
        <div class="card ms_bg-card shadow py-4 my-5">

            <form action="{{ route('apartments.update', ['apartment' => $apartment->slug]) }}" enctype="multipart/form-data"
                method="POST" class="col-12 col-md-10 col-lg-9 col-xl-8 m-auto">
                @csrf
                @method('PUT')

                {{-- title --}}
                <div class="mb-3">
                    <h4>Title</h4>
                    <input placeholder="Short description" type="text" required minlength="5" maxlength="50"
                        class="form-control @error('title') is-invalid @enderror @if (!empty(old('title')) && !$errors->has('title')) is-valid @endif"
                        id="title" name="title" value="{{ $apartment->title ?? old('title') }}">
                    @error('title')
                        <p class="invalid-feedback">{{ $message }}</p>
                    @enderror
                </div>

                <h4 class="mt-4">Apartment info</h4>

                {{-- rooms --}}
                <div class="mb-3">
                    <label for="num_rooms" class="form-label ms_font-color">rooms</label>
                    <input type="number" min="1" max="254"
                        class="form-control @error('num_rooms') is-invalid @enderror @if (!empty(old('num_rooms')) && !$errors->has('num_rooms')) is-valid @endif"
                        id="num_rooms" name="num_rooms"
                        value="{{ $apartment->apartment_info->num_rooms ?? old('num_rooms') }}">
                    @error('num_rooms')
                        <p class="invalid-feedback">{{ $message }}</p>
                    @enderror
                </div>

                {{-- beds --}}
                <div class="mb-3">
                    <label for="num_beds" class="form-label ms_font-color">beds</label>
                    <input type="number" min="1" max="254"
                        class="form-control @error('num_beds') is-invalid @enderror @if (!empty(old('num_beds')) && !$errors->has('num_beds')) is-valid @endif"
                        id="num_beds" name="num_beds"
                        value="{{ $apartment->apartment_info->num_beds ?? old('num_beds') }}">
                    @error('num_beds')
                        <p class="invalid-feedback">{{ $message }}</p>
                    @enderror
                </div>

                {{-- bathrooms --}}
                <div class="mb-3">
                    <label for="num_bathrooms" class="form-label ms_font-color">bathrooms</label>
                    <input type="number" min="1" max="254"
                        class="form-control @error('num_bathrooms') is-invalid @enderror @if (!empty(old('num_bathrooms')) && !$errors->has('num_bathrooms')) is-valid @endif"
                        id="num_bathrooms" name="num_bathrooms"
                        value="{{ $apartment->apartment_info->num_bathrooms ?? old('num_bathrooms') }}">
                    @error('num_bathrooms')
                        <p class="invalid-feedback">{{ $message }}</p>
                    @enderror
                </div>

                {{-- meters square --}}
                <div class="mb-3">
                    <label for="mt_square" class="form-label ms_font-color">meters square</label>
                    <input type="number" min="10" max="2500"
                        class="form-control @error('mt_square') is-invalid @enderror @if (!empty(old('mt_square')) && !$errors->has('mt_square')) is-valid @endif"
                        id="mt_square" name="mt_square"
                        value="{{ $apartment->apartment_info->mt_square ?? old('mt_square') }}">
                    @error('mt_square')
                        <p class="invalid-feedback">{{ $message }}</p>
                    @enderror
                </div>

                {{-- services --}}
                <h4 class="mt-4">Services</h4>

                <div class="btn-group btn-group-sm my-3" role="group" aria-label="Basic checkbox toggle button group">
                    <div class="row g-2 justify-content-start align-items-center">
                        @foreach ($services as $service)
                            <div class="col">
                                <input type="checkbox" class="btn-check" id="service_{{ $service->id }}" name="services[]"
                                    value="{{ $service->id }}" autocomplete="off" @checked($errors->any() ? in_array($service->id, old('services', [])) : $apartment->services->contains($service))>
                                <label class="btn btn-outline-primary ms_whitespace" for="service_{{ $service->id }}">
                                    {{ $service->name }}
                                </label>
                            </div>
                        @endforeach
                        @error('services')
                            <p class="text-danger">{{ $message }}</p>
                        @enderror
                    </div>
                </div>

                {{-- visibility --}}
                <h4 class="mt-5">visibility</h4>
                <div class="btn-group btn-group-sm my-3" role="group" aria-label="Basic checkbox toggle button group">
                    <div class="row g-2 justify-content-start align-items-center">
                        <div class="col">
                            <input type="radio" class="btn-check" id="visibility" name="visibility" value="1"
                                autocomplete="off" @checked($errors->any() ? old('visibility') : $apartment->visibility)>
                            <label class="btn btn-outline-primary ms_whitespace" for="visibility">
                                visible
                            </label>
                        </div>
                        <div class="col">
                            <input type="radio" class="btn-check" id="not-visibility" name="visibility"
                                value="0" autocomplete="off" @checked(!($errors->any() ? old('visibility') : $apartment->visibility))>
                            <label class="btn btn-outline-primary ms_whitespace" for="not-visibility">
                                not visible
                            </label>
                        </div>
                        @error('visibility')
                            <p class="invalid-feedback is-invalid">{{ $message }}</p>
                        @enderror
                    </div>
                </div>

                {{-- images --}}
                <h4 class="mt-4">Images</h4>

                <div class="mb-3 card ms_bg-small-card rounded p-3">
                    <label for="image_path" class="form-label ms_font-color">Apartment images</label>
                    <input type="file"
                        class="form-control @error('image_path.*') is-invalid @enderror @if (!empty(old('image_path')) && !$errors->has('image_path')) is-valid @endif"
                        id="image_path" name="image_path[]" value="{{ old('image_path') }}" multiple>
                    @error('image_path.*')
                        <p class="invalid-feedback">{{ $message }}</p>
                    @enderror

                    <div class="images-container col-8 my-5 gap-5 flex-column mx-auto">

                    </div>


                    @if (count($apartment->images) > 0)
                        <h4 class="text-center my-3">Check to delete</h4>
                        <div class="d-flex flex-wrap justify-content-center align-items-center gap-4 my-5">
                            @foreach ($apartment->images as $image)
                                <div class="card col-12 col-md-6 col-lg-4">
                                    <img src="{{ asset('storage/image_path/' . $image->image_path) }}"
                                        class="ms_img card-img-top " alt="...">
                                    <div class="card-body">
                                        <div class="form-check flex-grow-1">
                                            <input class="form-check-input visually-hidden" type="checkbox"
                                                name="images[]" id="image{{ $image->id }}"
                                                value="{{ $image->id }}">
                                            <label class="form-check-label d-flex align-items-center"
                                                for="image{{ $image->id }}">
                                                <span class="checkbox-custom"></span>
                                                <span>Check to delete</span>
                                            </label>
                                        </div>
                                    </div>
                                </div>
                            @endforeach
                        </div>
                    @endif



                </div>
                <div class="d-flex gap-3">
                    <button type="submit" class="my-btn-blue">upload</button>
                    <a href="{{ route('apartments.show', ['apartment'=>$apartment->slug])}}" class="my-btn-blue ">back
                    </a>
                </div>
            </form>
        </div>
    @endsection
