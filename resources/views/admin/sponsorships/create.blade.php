@extends('layouts.app')

@section('content')
    <script src="https://js.braintreegateway.com/web/dropin/1.42.0/js/dropin.min.js"></script>


    @if (session('error'))
        <div class="alert alert-danger text-center col-12 col-md-5 col-lg-4 m-auto my-3">
            {{ session('error') }}
        </div>
    @endif

    <h4 class="text-center my-5">Activate a new sponsorization for {{ $apartment->title }}</h4>
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
            <div class="card ms_bg-card py-5">
                <form action="{{ route('sponsorships.store') }}" method="POST" id="payment-form">
                    @csrf
                    {{-- Sponsorization type --}}
                    <div class="text-center mt-2">
                        <label class="mt-4 mb-1 ms_font-color fs-4" for="sponsorship">Type:</label>
                        <select
                            class="form-control w-50 mt-2 text-center mx-auto @error('sponsorship_id') is-invalid @enderror @if (!empty(old('sponsorship_id')) && !$errors->has('sponsorship_id')) is-valid @endif"
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
                        <label class="mt-4 mb-1 ms_font-color fs-4" for="startDate">Start date:</label>
                        <input type="date"
                            class="form-control w-50 mx-auto mt-2 @error('start_date') is-invalid @enderror @if (!empty(old('start_date')) && !$errors->has('start_date')) is-valid @endif"
                            name="start_date" id="startDate" min="{{ date('Y-m-d') }}" required>
                        @error('start_date')
                            <p class="invalid-feedback">{{ $message }}</p>
                        @enderror
                    </div>
                    <div class="text-center mt-2">
                        <label class="mt-4 mb-1 ms_font-color fs-4" for="startTime">Start time:</label>
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
                    <div class="d-flex justify-content-center my-5">
                        <button type="submit" class="btn my-btn-blue " id="submit-button">Chekout Payment</button>
                    </div>
                </form>
            </div>


            <script>
                let route = 'http://localhost:8000/payment;
                let button = document.querySelector('#submit-button');
                braintree.dropin.create({
                    authorization: '{{ $token }}',
                    container: '#dropin-container'
                }, function(createErr, instance) {
                    button.addEventListener('click', function() {
                        instance.requestPaymentMethod(function(err, payload) {
                            axios.post(route, {
                                    nonce: payload.nonce
                                }, {
                                    headers: {
                                        'X-CSRF-TOKEN': document.querySelector(
                                            'meta[name="csrf-token"]').getAttribute('content')
                                    }
                                })
                                .then(function(response) {
                                    console.log('success', payload.nonce);
                                })
                                .catch(function(error) {
                                    console.log('error', payload.nonce);
                                });
                        });
                    });
                });
            </script>
        @endif
    @endsection
