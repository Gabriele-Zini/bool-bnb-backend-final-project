<?php

namespace App\Http\Controllers;

use App\Models\ApartmentSponsorship;
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
            'environment' => env('BRAINTREE_ENVIRONMENT'),
            'merchantId' => env('BRAINTREE_MERCHANT_ID'),
            'publicKey' => env('BRAINTREE_PUBLIC_KEY'),
            'privateKey' => env('BRAINTREE_PRIVATE_KEY'),
        ]);

        $clientToken = $gateway->clientToken()->generate();
        Session::put('braintree_token', $clientToken);
        return view('admin.braintree', ['token' => $clientToken, 'apartment' => $apartmentSlug, 'sponsorship' => $sponsorship]);
    }

    public function processTransaction(Request $request)
    {
       
        $gateway = new Gateway([
            'environment' => env('BRAINTREE_ENVIRONMENT'),
            'merchantId' => env('BRAINTREE_MERCHANT_ID'),
            'publicKey' => env('BRAINTREE_PUBLIC_KEY'),
            'privateKey' => env('BRAINTREE_PRIVATE_KEY'),
        ]);
        $nonceFromTheClient = $request->input('nonce');

        $data = $request->all();
        $info = $data['info'];
        $result = $gateway->transaction()->sale([
            'amount' => $info['price'],
            'paymentMethodNonce' => $nonceFromTheClient,
            'options' => [
                'submitForSettlement' => true
            ]
        ]);

        if ($result->success) {
            $apartment_sponsorship = new ApartmentSponsorship;
            $apartment_sponsorship->start_date = $info['start_date'];
            $apartment_sponsorship->expiration_date = $info['expiration_date'];
            $apartment_sponsorship->sponsorship_id =  $info['sponsorship_id'];
            $apartment_sponsorship->apartment_id = $info['apartment_id'];
            $apartment_sponsorship->save();

            $data = [
                'request' => $info['price'],
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
