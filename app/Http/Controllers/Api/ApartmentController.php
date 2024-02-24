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

    public function getFilteredApartments(Request $request)
    {

        $query = Apartment::where('visibility', 1);

        if ($request->has('num_beds')) {
            $query->whereHas('apartment_info', function ($q) use ($request) {
                $q->where('num_beds', $request->num_beds);
            });
        }

        if ($request->has('num_rooms')) {
            $query->whereHas('apartment_info', function ($q) use ($request) {
                $q->where('num_rooms', $request->num_rooms);
            });
        }

        if ($request->has('num_bathrooms')) {
            $query->whereHas('apartment_info', function ($q) use ($request) {
                $q->where('num_bathrooms', $request->num_bathrooms);
            });
        }

        if ($request->has('mt_square')) {
            $query->whereHas('apartment_info', function ($q) use ($request) {
                $q->where('mt_square', $request->mt_square);
            });
        }

        $query->with('apartment_info', 'services');

        $apartments = $query->get();

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
}
