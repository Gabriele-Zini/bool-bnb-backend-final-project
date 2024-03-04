@extends('layouts.app')

@section('content')
    <div class="container my-5">

        @if (session('error'))
            <div class="alert alert-danger col-12 col-md-10 col-lg-9 col-xl-8 m-auto my-3">
                {{ session('error') }}
            </div>
        @endif


        <div class="card py-5 ms_bg-card px-3 shadow">
            <form action="{{ route('apartments.store') }}" enctype="multipart/form-data" method="POST"
                class="col-12 col-md-10 col-lg-9 col-xl-8 m-auto">
                @csrf

                {{-- title --}}
                <div class="mb-3">
                    <h4>Title</h4>
                    <input placeholder="Short description" type="text" required minlength="5" maxlength="50"
                        class="form-control @error('title') is-invalid @enderror @if (!empty(old('title')) && !$errors->has('title')) is-valid @endif"
                        id="title" name="title" value="{{ old('title') }}">
                    @error('title')
                        <p class="invalid-feedback">{{ $message }}</p>
                    @enderror
                </div>

                <div id="address-container" class="card ms_bg-small-card px-3 ms_font-color py-1 mb-3 d-none">
                    <p id="address" class="lh-lg"></p>
                </div>

                {{-- country code --}}
                <div class="mb-3 d-none">
                    <label for="country_code" class="form-label ms_font-color">country code</label>
                    <input type="text"
                        class="form-control @error('country_code') is-invalid @enderror @if (!empty(old('country_code')) && !$errors->has('country_code')) is-valid @endif"
                        id="country_code" name="country_code" value="{{ old('country_code') }}">
                </div>
                @error('country_code')
                    <p class="invalid-feedback">{{ $message }}</p>
                @enderror


                {{-- city --}}
                <div class="mb-3 d-none">
                    <label for="city" class="form-label ms_font-color">City</label>
                    <input type="text"
                        class="form-control @error('city') is-invalid @enderror @if (!empty(old('city')) && !$errors->has('city')) is-valid @endif"
                        id="city" name="city" value="{{ old('city') }}">
                </div>

                {{-- street_name --}}
                <div class="mb-3 d-none">
                    <label for="street_name" class="form-label ms_font-color">Street Name</label>
                    <input type="text"
                        class="form-control @error('street_name') is-invalid @enderror @if (!empty(old('street_name')) && !$errors->has('street_name')) is-valid @endif"
                        id="street_name" name="street_name" value="{{ old('street_name') }}">
                </div>

                {{-- street_number --}}
                <div class="mb-3 d-none">
                    <label for="street_number" class="form-label ms_font-color">street number</label>
                    <input type="text"
                        class="form-control @error('street_number') is-invalid @enderror @if (!empty(old('street_number')) && !$errors->has('street_number')) is-valid @endif"
                        id="street_number" name="street_number" value="{{ old('street_number') }}">
                </div>

                {{-- postal code --}}
                <div class="mb-3 d-none">
                    <label for="postal_code" class="form-label ms_font-color">postal code</label>
                    <input type="text"
                        class="form-control @error('postal_code') is-invalid @enderror @if (!empty(old('postal_code')) && !$errors->has('postal_code')) is-valid @endif"
                        id="postal_code" name="postal_code" value="{{ old('postal_code') }}">
                </div>

                <h5 class="mt-4 ms_font-color">Select your address</h5>
                <div class="map form-control @error('city') is-invalid @enderror @error('street_name') is-invalid @enderror @error('street_number') is-invalid @enderror @error('postal_code') is-invalid @enderror"
                    id="map">
                </div>

                @error('city')
                    <p class="form-control my-2 is-invalid invalid-feedback">{{ $message }}</p>
                @enderror
                @error('street_name')
                    <p class="form-control my-2 is-invalid invalid-feedback">{{ $message }}</p>
                @enderror
                @error('street_number')
                    <p class="form-control my-2 is-invalid invalid-feedback">{{ $message }}</p>
                @enderror
                @error('postal_code')
                    <p class="form-control my-2 is-invalid invalid-feedback">{{ $message }}</p>
                @enderror


                <h4 class="mt-4">Apartment info</h4>

                {{-- rooms --}}
                <div class="mb-3">
                    <label for="num_rooms" class="form-label ms_font-color">rooms</label>
                    <input type="number" min="1" max="254"
                        class="form-control @error('num_rooms') is-invalid @enderror @if (!empty(old('num_rooms')) && !$errors->has('num_rooms')) is-valid @endif"
                        id="num_rooms" name="num_rooms" value="{{ old('num_rooms') }}">
                    @error('num_rooms')
                        <p class="invalid-feedback form-control my-2 is-invalid">{{ $message }}</p>
                    @enderror
                </div>

                {{-- beds --}}
                <div class="mb-3">
                    <label for="num_beds" class="form-label ms_font-color">beds</label>
                    <input type="number" min="1" max="254"
                        class="form-control @error('num_beds') is-invalid @enderror @if (!empty(old('num_beds')) && !$errors->has('num_beds')) is-valid @endif"
                        id="num_beds" name="num_beds" value="{{ old('num_beds') }}">
                    @error('num_beds')
                        <p class="invalid-feedback form-control my-2 is-invalid">{{ $message }}</p>
                    @enderror
                </div>

                {{-- bathrooms --}}
                <div class="mb-3">
                    <label for="num_bathrooms" class="form-label ms_font-color">bathrooms</label>
                    <input type="number" min="1" max="254"
                        class="form-control @error('num_bathrooms') is-invalid @enderror @if (!empty(old('num_bathrooms')) && !$errors->has('num_bathrooms')) is-valid @endif"
                        id="num_bathrooms" name="num_bathrooms" value="{{ old('num_bathrooms') }}">
                    @error('num_bathrooms')
                        <p class="invalid-feedback form-control my-2 is-invalid">{{ $message }}</p>
                    @enderror
                </div>

                {{-- meters square --}}
                <div class="mb-3">
                    <label for="mt_square" class="form-label ms_font-color">meters square</label>
                    <input type="number" min="10" max="2500"
                        class="form-control @error('mt_square') is-invalid @enderror @if (!empty(old('mt_square')) && !$errors->has('mt_square')) is-valid @endif"
                        id="mt_square" name="mt_square" value="{{ old('mt_square') }}">
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
                                <input type="checkbox" class="btn-check @error('services') invalid feedback @enderror"
                                    id="service_{{ $service->id }}" name="services[]" value="{{ $service->id }}"
                                    autocomplete="off" @checked(in_array($service->id, old('services', [])))>
                                <label class="btn btn-outline-primary ms_whitespace" for="service_{{ $service->id }}">
                                    {{ $service->name }}
                                </label>
                            </div>
                        @endforeach
                        @error('services')
                            <p class="text-danger my-1 py-1 px-2 border border-1 border-danger rounded">{{ $message }}
                            </p>
                        @enderror
                    </div>
                </div>

                {{-- visibility --}}
                <h4 class="mt-4">Visibility</h4>
                <div class="btn-group btn-group-sm my-3" role="group" aria-label="Basic checkbox toggle button group">
                    <div class="row g-2 justify-content-start align-items-center">
                        <div class="col">
                            <input type="radio"
                                class="btn-check @error('visibility') form-control is-invalid invalid feedback @enderror"
                                @checked(true) id="visibility" name="visibility" value="1"
                                autocomplete="off">
                            <label class="btn btn-outline-primary ms_whitespace" for="visibility">
                                visible
                            </label>
                        </div>
                        <div class="col">
                            <input type="radio"
                                class="btn-check @error('visibility') form-control is-invalid invalid feedback @enderror"
                                id="not-visibility" name="visibility" value="0" autocomplete="off">
                            <label class="btn btn-outline-primary ms_whitespace" for="not-visibility">
                                not visible
                            </label>
                        </div>
                    </div>
                </div>

                @error('visibility')
                    <p class="form-control my-2 is-invalid invalid-feedback">{{ $message }}</p>
                @enderror

                {{-- images --}}
                <div class="card ms_bg-small-card rounded p-3">
                    <h4 class="mt-4">Images</h4>

                    <input type="file" id="image_path"
                        class="form-control my-4 @error('image_path.*') is-invalid @enderror" name="image_path[]"
                        multiple>

                    @error('image_path.*')
                        <p class="invalid-feedback">{{ $message }}</p>
                    @enderror

                    <div class="images-container col-8 my-5 gap-5 flex-column mx-auto">
                    </div>


                </div>
                <button type="submit" class="my-btn-blue mt-3">upload</button>
            </form>
        </div>
    </div>
@endsection
