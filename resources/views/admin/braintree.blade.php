@extends('layouts.app')

@section('content')
    <script src="https://js.braintreegateway.com/web/dropin/1.42.0/js/dropin.min.js"></script>

    <h2 class="text-center mt-5">Braintree Payment System</h2>
    <div class="py-12">
        @csrf
        <input type="hidden" name="_token" value="{{ csrf_token() }}">
        <input type="hidden" id="apartment" name="apartment" value="{{ $apartment }}">
        <input type="hidden" id="price" name="price" value="{{ $sponsorship['price'] }}">
        <input type="hidden" id="start_date" name="start_date" value="{{ $sponsorship['start_date'] }}">
        <input type="hidden" id="expiration_date" name="expiration_date" value="{{ $sponsorship['expiration_date'] }}">
        <input type="hidden" id="sponsorship_id" name="sponsorship_id" value="{{ $sponsorship['sponsorship_id'] }}">
        <input type="hidden" id="apartment_id" name="apartment_id" value="{{ $sponsorship['apartment_id'] }}">
        <div class=" col-12 col-md10 col-lg-6 col-xl-5 mx-auto">
            <div id="dropin-container"></div>
            <a id="submit-button" class="btn btn-sm btn-success">Submit payment</a>
        </div>

    </div>


    <script>
        let info = {
            price: document.querySelector('#price').value,
            slug: document.querySelector('#apartment').value,
            start_date: document.querySelector('#start_date').value,
            expiration_date: document.querySelector('#expiration_date').value,
            sponsorship_id: document.querySelector('#sponsorship_id').value,
            apartment_id: document.querySelector('#apartment_id').value
        };
        let button = document.querySelector('#submit-button');
        braintree.dropin.create({
            authorization: '{{ $token }}',
            container: '#dropin-container',

        }, function(createErr, instance) {
            button.addEventListener('click', function() {
                instance.requestPaymentMethod(function(err, payload) {
                    axios.post('{{ route('transaction') }}', {
                            nonce: payload.nonce,
                            info: info
                        }, {
                            headers: {
                                'X-CSRF-TOKEN': document.querySelector(
                                    'meta[name="csrf-token"]').getAttribute('content')
                            }
                        })
                        .then(function(response) {
                            console.log('success', payload.nonce);
                            console.log(response);
                            button.setAttribute('href',
                                "{{ route('sponsorships.index', ['apartment' => $apartment]) }}"
                                );
                            button.click();
                            history.pushState(null, null, history.replaceState);
                            window.addEventListener('popstate', function(event) {
                                history.pushState(null, null, history.replaceState);
                                console.log('sticazzi');
                            });
                        })
                        .catch(function(error) {
                            console.log('error', payload.nonce);
                        });
                });
            });
        });
    </script>
@endsection
