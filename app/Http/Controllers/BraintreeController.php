<?php

namespace App\Http\Controllers;

use Braintree\Gateway;

use Illuminate\Http\Request;

class BraintreeController extends Controller
{
    public function token(Request $request)
    {

        $gateway = new \Braintree\Gateway([
            'environment' => 'sandbox',
            'merchantId' => 'ympkctn64j5ws654',
            'publicKey' => '4g4bdtcpcxxtz3xj',
            'privateKey' => 'eeaae14db9451cbf55bec4b30dd00b23'
        ]);

        $clientToken = $gateway->clientToken()->generate();
        return view('admin.braintree', ['token' => $clientToken]);
    }

    public function processTransaction(Request $request)
    {
        $gateway = new \Braintree\Gateway([
            'environment' => 'sandbox',
            'merchantId' => 'ympkctn64j5ws654',
            'publicKey' => '4g4bdtcpcxxtz3xj',
            'privateKey' => 'eeaae14db9451cbf55bec4b30dd00b23'
        ]);

        $nonceFromTheClient = $request->input('nonce');

        $result = $gateway->transaction()->sale([
            'amount' => '10.00',
            'paymentMethodNonce' => $nonceFromTheClient,
            'options' => [
                'submitForSettlement' => true
            ]
        ]);

        if ($result->success) {
            // Transazione completata con successo
            return view('dashboard');
        } else {
            // La transazione ha fallito
            return redirect()->back()->withErrors(['error' => 'La transazione non è stata completata.']);
        }
    }
}
