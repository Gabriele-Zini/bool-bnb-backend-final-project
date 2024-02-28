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
            'merchantId' => 'ympkctn64j5ws654',
            'publicKey' => 'rk427fdhzk4qh6pg',
            'privateKey' => '8c200d7dc950bd140f4e5d430fd0f7c1'
        ]);

        $clientToken = $gateway->clientToken()->generate();
        Session::put('braintree_token', $clientToken);
        return view('admin.braintree', ['token' => $clientToken, 'apartment' => $apartmentSlug, 'sponsorship' => $sponsorship]);
    }

    public function processTransaction(Request $request)
    {
        dd($request);
        $gateway = new Gateway([
            'environment' => 'sandbox',
            'merchantId' => 'ympkctn64j5ws654',
            'publicKey' => 'rk427fdhzk4qh6pg',
            'privateKey' => '8c200d7dc950bd140f4e5d430fd0f7c1'
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
