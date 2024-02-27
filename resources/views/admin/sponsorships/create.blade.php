@extends('layouts.app')

@section('content')
    <script src="https://js.braintreegateway.com/web/dropin/1.42.0/js/dropin.min.js"></script>


    @if (session('error'))
        <div class="alert alert-danger text-center col-12 col-md-5 col-lg-4 m-auto my-3">
            {{ session('error') }}
        </div>
    @endif

    <h2 class="text-center">Activate a new sponsorization for {{ $apartment->title }}</h2>
    <div class="container">
        @if (session('message'))
            <div class="alert text-center alert-success col-12 col-md-5 col-lg-4 m-auto my-3">
                {{ session('message') }}
                {{-- sponsorships --}}
                <a href="{{ route('sponsorships.index', ['apartment' => $apartment->slug]) }}">Return
                    to sponsorships
                </a>
            </div>
        @endif
        @if (!session('message'))
            <form action="{{ route('sponsorships.store') }}" method="POST" id="payment-form">
                @csrf
                {{-- Sponsorization type --}}
                <div class="text-center mt-2">
                    <label for="sponsorship">Type:</label>
                    <select
                        class="form-control w-50 text-center mx-auto @error('sponsorship_id') is-invalid @enderror @if (!empty(old('sponsorship_id')) && !$errors->has('sponsorship_id')) is-valid @endif"
                        name="sponsorship_id" id="sponsorship" required>
                        <option value="">Select a sponsorization type</option>
                        @foreach ($sponsorship as $sponsor)
                            <option value="{{ $sponsor->id }}" required>{{ @ucwords($sponsor->name) }} - €
                                {{ $sponsor->price }}</option>
                        @endforeach
                    </select>
                    @error('sponsorship_id')
                        <p class="invalid-feedback">{{ $message }}</p>
                    @enderror
                </div>

                <div class="text-center mt-2">
                    <label for="startDate">Start date:</label>
                    <input type="date"
                        class="form-control w-50 mx-auto mt-2 @error('start_date') is-invalid @enderror @if (!empty(old('start_date')) && !$errors->has('start_date')) is-valid @endif"
                        name="start_date" id="startDate" min="{{ date('Y-m-d') }}" required>
                    @error('start_date')
                        <p class="invalid-feedback">{{ $message }}</p>
                    @enderror
                </div>
                <div class="text-center mt-2">
                    <label for="startTime">Start time:</label>
                    <input type="time"
                        class="form-control w-25 mx-auto mt-2 @error('start_time') is-invalid @enderror @if (!empty(old('start_time')) && !$errors->has('start_time')) is-valid @endif"
                        name="start_time" id="startTime" required>
                    @error('start_time')
                        <p class="invalid-feedback">{{ $message }}</p>
                    @enderror
                </div>

                <div class="d-none">
                    <input type="number" name="apartment_id" value="{{ $apartment->id }}">
                </div>

                {{--   <div class="text-center mt-2">
                    <input type="hidden" id="braintree-token" name="braintree_token" value="">
                <button type="submit" class="btn btn-success">Buy</button>
            </div> --}}


                <input type="hidden" id="braintree-token" name="braintree_token" value="{{ $token }}">


                <div class="my-4 col-12 col-md-8 col-lg-7 mx-auto">
                    <div class="">
                        <div id="dropin-wrapper">
                            <div id="checkout-message"></div>
                            <div id="dropin-container"></div>
                            <button class="btn btn-primary" type="submit" id="submit-button">
                                Submit payment
                            </button>
                            {{-- sponsorships --}}
                            <a href="{{ route('sponsorships.index', ['apartment' => $apartment->slug]) }}"
                                class="btn btn-warning">Return to sponsorships
                            </a>
                        </div>
                    </div>
                </div>


            </form>
        @endif
    @endsection
