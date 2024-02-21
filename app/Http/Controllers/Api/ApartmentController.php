<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Apartment;

class ApartmentController extends Controller
{

    public function index()
    {
        $apartments = Apartment::with(['services', 'apartment_info', 'user', 'images'])->paginate(20);

        if ($apartments) {
            return response()->json(
                [
                    'result' => $apartments,
                    'success' => true,
                ]
            );
        } else {
            return response()->json(
                [
                    'success' => false,
                    'message' => 'No apartments found'
                ]
            );
        }
    }

    public function show(string $slug)
    {
        $apartment = Apartment::with(['services', 'apartment_infos', 'user'])->where('slug', $slug)->first();
        if ($apartment) {

            return response()->json(
                [
                    'result' => $apartment,
                    'success' => true,
                ]
            );
        } else {
            return response()->json(
                [
                    'success' => false,
                    'message' => 'Il progetto non esiste'
                ]
            );
        }
    }
}
