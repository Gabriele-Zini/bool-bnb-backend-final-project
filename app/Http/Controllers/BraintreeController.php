<?php

namespace App\Http\Controllers;

use Braintree\Gateway;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Session;

class BraintreeController extends Controller
{
    public function token(Request $request)
    {
        $apartmentSlug = $request->apartment;
        $sponsorship = $request->sponsorship_data;
        $gateway = new Gateway([
            'environment' => 'sandbox',
            'merchantId' => '7snbfz9sqqk62yfq',
            'publicKey' => 'v467n9qddqbrbq2b',
            'privateKey' => 'b9430c58b1145441329fcf838562b6ef'
        ]);

        $clientToken = $gateway->clientToken()->generate();
        Session::put('braintree_token', $clientToken);
        return view('admin.braintree', ['token' => $clientToken, 'apartment' => $apartmentSlug, 'sponsorship' => $sponsorship]);
    }

    public function processTransaction(Request $request)
    {
       
        $gateway = new Gateway([
            'environment' => 'sandbox',
            'merchantId' => '7snbfz9sqqk62yfq',
            'publicKey' => 'v467n9qddqbrbq2b',
            'privateKey' => 'b9430c58b1145441329fcf838562b6ef'
        ]);
        $nonceFromTheClient = $request->input('nonce');

        $result = $gateway->transaction()->sale([
            'amount' => '11.00',
            'paymentMethodNonce' => $nonceFromTheClient,
            'options' => [
                'submitForSettlement' => true
            ]
        ]);

        if ($result->success) {
            $data = [
                'success' => true,
                'message' => "Transazione eseguita con Successo!"
            ];
            return response()->json($data, 200);
        } else {
            $data = [
                'success' => false,
                'message' => "Transazione Fallita!!"
            ];
            return response()->json($data, 401);
        }
    }
}
