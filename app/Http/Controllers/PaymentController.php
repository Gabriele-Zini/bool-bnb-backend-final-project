<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Braintree\Gateway;
use App\Models\Sponsorship;
use App\Models\Apartment;


class PaymentController extends Controller
{
    protected $gateway;

    public function __construct(Gateway $gateway)
    {
        $this->gateway = $gateway;
    }

    public function token()
    {
        return response()->json(['token' => $this->gateway->clientToken()->generate()]);
    }
}
