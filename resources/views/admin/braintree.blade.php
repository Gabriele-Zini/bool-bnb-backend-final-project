@extends('layouts.app')

@section('content')
<script src="https://js.braintreegateway.com/web/dropin/1.42.0/js/dropin.min.js"></script>

    <h2>Braintree Payment System</h2>
    <div class="py-12">
        @csrf
        <input type="hidden" name="_token" value="{{ csrf_token() }}">
        <input type="hidden" name="apartment" value="{{ $apartment }}">
        <input type="hidden" name="price" value="{{ $sponsorship['price'] }}">
        <input type="hidden" name="start_date" value="{{ $sponsorship['start_date'] }}">
        <input type="hidden" name="expiration_date" value="{{ $sponsorship['expiration_date'] }}">
        <input type="hidden" name="sponsorship_id" value="{{ $sponsorship['sponsorship_id'] }}">
        <input type="hidden" name="apartment_id" value="{{ $sponsorship['apartment_id'] }}">
        <div id="dropin-container"></div>
        <div>
            <a id="submit-button" class="btn btn-sm btn-success">Submit payment</a>
        </div>

    </div>
    

    <script>
        let route = 'http://localhost:8000/payment'
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
@endsection

