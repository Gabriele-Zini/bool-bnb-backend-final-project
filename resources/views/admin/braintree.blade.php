@extends('layouts.app')

@section('content')
    <script src="https://js.braintreegateway.com/web/dropin/1.42.0/js/dropin.min.js"></script>

    <div class="col-12 col-md-10 col-lg-8 px-3 mx-auto mt-5">
        <div class="py-12 card ms_bg-card shadow">
            <h4 class="text-center mt-5">Braintree Payment System</h4>
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
                <a id="submit-button" class="btn my-btn-blue mt-3 mb-5">Submit Payment</a>
            </div>
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
                            if (document.querySelector('.braintree-toggle')) {
                                document.querySelector('.braintree-toggle').remove();
                            }
                            button.click();
                            history.pushState(null, null, 'pageExpired');
                            window.addEventListener('popstate', function(event) {
                                history.pushState(null, null, history.replaceState);
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
