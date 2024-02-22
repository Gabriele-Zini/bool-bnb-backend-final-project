@extends('layouts.app')

@section('content')
    <div class="container my-5">

        @if (session('message'))
            <div class="alert alert-success col-12 col-md-10 col-lg-9 col-xl-8 m-auto my-3">
                {{ session('message') }}
            </div>
        @endif

        <form action="{{ route('apartments.update', ['apartment' => $apartment->slug]) }}" enctype="multipart/form-data"
            method="POST" class="col-12 col-md-10 col-lg-9 col-xl-8 m-auto">
            @csrf
            @method('PUT')

            {{-- title --}}
            <div class="mb-3">
                <h5>Title</h5>
                <input placeholder="Short description" type="text"
                    class="form-control @error('title') is-invalid @enderror @if (!empty(old('title')) && !$errors->has('title')) is-valid @endif"
                    id="title" name="title" value="{{ $apartment->title ?? old('title') }}">
                @error('title')
                    <p class="invalid-feedback">{{ $message }}</p>
                @enderror
            </div>

            <h5 class="mt-4">Apartment info</h5>

            {{-- rooms --}}
            <div class="mb-3">
                <label for="num_rooms" class="form-label">rooms</label>
                <input type="number"
                    class="form-control @error('num_rooms') is-invalid @enderror @if (!empty(old('num_rooms')) && !$errors->has('num_rooms')) is-valid @endif"
                    id="num_rooms" name="num_rooms" value="{{ $apartment->apartment_info->num_rooms ?? old('num_rooms') }}">
                @error('num_rooms')
                    <p class="invalid-feedback">{{ $message }}</p>
                @enderror
            </div>

            {{-- beds --}}
            <div class="mb-3">
                <label for="num_beds" class="form-label">beds</label>
                <input type="number"
                    class="form-control @error('num_beds') is-invalid @enderror @if (!empty(old('num_beds')) && !$errors->has('num_beds')) is-valid @endif"
                    id="num_beds" name="num_beds" value="{{ $apartment->apartment_info->num_beds ?? old('num_beds') }}">
                @error('num_beds')
                    <p class="invalid-feedback">{{ $message }}</p>
                @enderror
            </div>

            {{-- bathrooms --}}
            <div class="mb-3">
                <label for="num_bathrooms" class="form-label">bathrooms</label>
                <input type="number"
                    class="form-control @error('num_bathrooms') is-invalid @enderror @if (!empty(old('num_bathrooms')) && !$errors->has('num_bathrooms')) is-valid @endif"
                    id="num_bathrooms" name="num_bathrooms"
                    value="{{ $apartment->apartment_info->num_bathrooms ?? old('num_bathrooms') }}">
                @error('num_bathrooms')
                    <p class="invalid-feedback">{{ $message }}</p>
                @enderror
            </div>

            {{-- meters square --}}
            <div class="mb-3">
                <label for="mt_square" class="form-label">meters square</label>
                <input type="number"
                    class="form-control @error('mt_square') is-invalid @enderror @if (!empty(old('mt_square')) && !$errors->has('mt_square')) is-valid @endif"
                    id="mt_square" name="mt_square"
                    value="{{ $apartment->apartment_info->mt_square ?? old('mt_square') }}">
                @error('mt_square')
                    <p class="invalid-feedback">{{ $message }}</p>
                @enderror
            </div>

            {{-- services --}}
            <h5 class="mt-4">Services</h5>

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
                        <input type="radio" class="btn-check" id="not-visibility" name="visibility" value="0"
                            autocomplete="off" @checked(!($errors->any() ? old('visibility') : $apartment->visibility))>
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
            <h5 class="mt-4">Images</h5>

            <div class="mb-3">
                <label for="image_path" class="form-label">Apartment images</label>
                <input type="file"
                    class="form-control @error('image_path.*') is-invalid @enderror @if (!empty(old('image_path')) && !$errors->has('image_path')) is-valid @endif"
                    id="image_path" name="image_path[]" value="{{ old('image_path') }}" multiple>
                @error('image_path.*')
                    <p class="invalid-feedback">{{ $message }}</p>
                @enderror
            </div>

            <div>
                <img id="preview-image" class="ms_show-image d-none" src="" alt="">
            </div>
            <button type="submit" class="btn btn-success">send</button>
        </form>
    </div>
@endsection
