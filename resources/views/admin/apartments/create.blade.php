@extends('layouts.app')

@section('content')
    <div class="container my-5">

        @if (session('error'))
            <div class="alert alert-danger col-12 col-md-5 col-lg-4 m-auto my-3">
                {{ session('error') }}
            </div>
        @endif

        <form action="{{ route('apartments.store') }}" enctype="multipart/form-data" method="POST"
            class="col-12 col-md-5 col-lg-4 m-auto">
            @csrf
            <div class="mb-3">
                <label for="title" class="form-label">Title</label>
                <input type="text"
                    class="form-control @error('title') is-invalid @enderror @if (!empty(old('title')) && !$errors->has('title')) is-valid @endif"
                    id="title" name="title" value="{{ old('title') }}">
                @error('title')
                    <p class="invalid-feedback">{{ $message }}</p>
                @enderror
            </div>

            {{-- country --}}
            <div class="mb-3">
                <label class="form-label" for="country">Country</label>
                <select class="form-select" name="country" id="country">
                    <option @selected(!old('country')) value="">No Country selected</option>
                    @foreach ($countryCodes as $countryCode)
                        <option @selected(old('country') == $countryCode['code']) value="{{ $countryCode['code'] }}">{{ $countryCode['name'] }}
                        </option>
                    @endforeach
                </select>
            </div>


            {{-- city --}}
            <div class="mb-3">
                <label for="city" class="form-label">Title</label>
                <input type="text"
                    class="form-control @error('city') is-invalid @enderror @if (!empty(old('city')) && !$errors->has('city')) is-valid @endif"
                    id="city" name="city" value="{{ old('city') }}">
                @error('city')
                    <p class="invalid-feedback">{{ $message }}</p>
                @enderror
            </div>


            {{-- street_name --}}
            <div class="mb-3">
                <label for="street_name" class="form-label">Street Name</label>
                <input type="text"
                    class="form-control @error('street_name') is-invalid @enderror @if (!empty(old('street_name')) && !$errors->has('street_name')) is-valid @endif"
                    id="street_name" name="street_name" value="{{ old('street_name') }}">
                @error('street_name')
                    <p class="invalid-feedback">{{ $message }}</p>
                @enderror
            </div>

            {{-- street_number --}}
            <div class="mb-3">
                <label for="street_number" class="form-label">street number</label>
                <input type="number"
                    class="form-control @error('street_number') is-invalid @enderror @if (!empty(old('street_number')) && !$errors->has('street_number')) is-valid @endif"
                    id="street_number" name="street_number" value="{{ old('street_number') }}">
                @error('street_number')
                    <p class="invalid-feedback">{{ $message }}</p>
                @enderror
            </div>

            <div class="btn-group btn-group-sm my-3" role="group" aria-label="Basic checkbox toggle button group">
                <div class="row g-2 justify-content-start align-items-center">
                    @foreach ($services as $service)
                        <div class="col">
                            <input type="checkbox" class="btn-check" id="service_{{ $service->id }}" name="services[]"
                                value="{{ $service->id }}" autocomplete="off" @checked(in_array($service->id, old('services', [])))>
                            <label class="btn btn-outline-primary" for="service_{{ $service->id }}">
                                {{ $service->name }}
                            </label>
                        </div>
                    @endforeach
                </div>
            </div>
            @error('servicies')
                <p class="text-danger">{{ $message }}</p>
            @enderror

            <div class="mb-3">
                <label for="image_path" class="form-label">Apartment images</label>
                <input type="file"
                    class="form-control @error('image_path') is-invalid @enderror @if (!empty(old('image_path')) && !$errors->has('image_path')) is-valid @endif"
                    id="image_path" name="image_path" value="{{ old('image_path') }}">
                @error('image_path')
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
