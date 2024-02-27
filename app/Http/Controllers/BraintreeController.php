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
        $nonceFromTheClient = $request->input('nonce');

        $result = $gateway->transaction()->sale([
            'amount' => '10.00',
            'paymentMethodNonce' => $nonceFromTheClient,
            'options' => [
                'submitForSettlement' => True
            ]
        ]);


            $data = [
                'success' => false,
                'message' => "Transazione Fallita!!",
                'result'=> $result,
            ];
            return response()->json($data, 200);
    }
}
