<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Apartment;
use App\Models\Service;
use Illuminate\Support\Facades\DB;

class ApartmentController extends Controller
{

    public function index(Request $request)
    {
        $apartmentsQuery = Apartment::with(['services', 'apartment_info', 'user', 'images'])->where('visibility', "=", 1);
        $services=Service::all();

        if($request->has('services')){
           /*  $servicesSelected = $request->get('services');
               $apartmentsQuery = $apartmentsQuery->join('apartment_service', 'services.id', '=','apartment_service.apartment_id')->join('apartments','apartment_service.id', '=','apartments.id')->select('apartmens.*');
               foreach($servicesSelected as $service){
                  $apartmentsQuery = $apartmentsQuery->where($service, '=', 'service.id');
               } */

        }
            $apartments = $apartmentsQuery->paginate(20);




        if ($apartments) {
            return response()->json(
                [
                    'result' => $apartments,
                    'services' => $services,
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

    public function show($slug)
    {
        $apartment = Apartment::with(['services', 'apartment_info', 'images'])->where('slug', $slug)->first();

        if ($apartment) {
            return response()->json([
                    'result' => $apartment,
                    'success' => true,
                ]);
        } else {
            return response()->json([
                    'success' => false,
                    'message' => 'L\'appartamento non è stato trovato'
                ]);
        }
    }

    public function getFilteredApartments(Request $request)
    {

        $query = Apartment::where('visibility', 1);

        if ($request->has('num_beds')) {
            $query->whereHas('apartment_info', function ($q) use ($request) {
                $q->where('num_beds', '<=', $request->num_beds);
            });
        }

        if ($request->has('num_rooms')) {
            $query->whereHas('apartment_info', function ($q) use ($request) {
                $q->where('num_rooms', '<=', $request->num_rooms);
            });
        }

        if ($request->has('num_bathrooms')) {
            $query->whereHas('apartment_info', function ($q) use ($request) {
                $q->where('num_bathrooms', '<=', $request->num_bathrooms);
            });
        }

        if ($request->has('mt_square')) {
            $query->whereHas('apartment_info', function ($q) use ($request) {
                $q->where('mt_square', '<=', $request->mt_square);
            });
        }

        $query->with('apartment_info', 'services');

        $apartments = $query->get();

        return response()->json(['apartments' => $apartments]);
    }


}
