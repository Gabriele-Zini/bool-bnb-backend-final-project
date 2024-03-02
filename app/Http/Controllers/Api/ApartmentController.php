<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Apartment;
use App\Models\ApartmentSponsorship;
use App\Models\Service;
use Carbon\Carbon;
use Illuminate\Support\Facades\DB;

class ApartmentController extends Controller
{

    public function index(Request $request)
    {

        $apartmentsQuery = DB::table('apartments')
            ->join('apartment_sponsorship', 'apartments.id', '=', 'apartment_sponsorship.apartment_id')
            ->join('images', 'apartments.id', '=', 'images.apartment_id')
            ->where('images.cover_image', '=', '1')
            ->where('apartments.visibility', '=', 1)
            ->where('apartment_sponsorship.start_date', '<=', Carbon::now())
            ->where('apartment_sponsorship.expiration_date', '>=', Carbon::now())
            ->orderBy('apartment_sponsorship.start_date', 'ASC');

        $services = Service::all();

        $apartments = $apartmentsQuery->paginate(8);

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
        $userLatitude = $request->input('latitude');
        $userLongitude = $request->input('longitude');
        if ($request->has('radius')) {
            $radius = $request->get('radius');
        } else {
            $radius = 20;
        }


        $query = Apartment::where('visibility', 1);
        $sponsorships = ApartmentSponsorship::all();

        // Filtri per i servizi
        /*    if ($request->has('services')) {
            $servicesSelected = $request->get('services');
            $query->whereHas('services', function ($q) use ($servicesSelected) {
                $q->whereIn('service_id', $servicesSelected);
            });
        }
 */
        // Filtri per i servizi se vogliamo che prenda solo quelli con tutti e due
        if ($request->has('services')) {
            $servicesSelected = $request->get('services');
            foreach ($servicesSelected as $service) {
                $query->whereHas('services', function ($q) use ($service) {
                    $q->where('name', $service);
                });
            }
        }



        // Filtri avanzati
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

        // Filtra per distanza
        if ($userLatitude && $userLongitude) {
            $query->whereRaw("(
            6378 * acos(
                cos(radians($userLatitude)) * cos(radians(latitude)) * cos(radians(longitude) - radians($userLongitude)) +
                sin(radians($userLatitude)) * sin(radians(latitude))
            )
        ) <= $radius");
        }

        $query->with('apartment_info', 'services', 'images');
        $apartments = $query->get();
        $sponsor=[];

        //Inserting in array $sponsor all the apartment id with an active sponsorship
        foreach ($apartments as $apartment) {
            foreach ($sponsorships as $sponsorship) {
                if ($apartment->id == $sponsorship->apartment_id && ($sponsorship->start_date <= Carbon::now() && $sponsorship->expiration_date >= Carbon::now())) {
                    $sponsor[] = [
                        'a' => $apartment->id
                    ];
                }
            }
        }

        $a=[];
        if (count($sponsor) > 0) {
            //Inserting in array $a the apartment id where is equal to the apartment ids in $sponsor['a']
            foreach ($apartments as $apartment) {
                foreach ($sponsor as $s) {
                    if ($apartment->id == $s['a']) {
                        $a[] = $apartment->id;
                        $apartment->sponsor = 1;
                    }
                }
            }

            //Inserting in $a all the others apartment ids
            foreach ($apartments as $apartment) {
                foreach ($sponsor as $s) {
                    if (!in_array($apartment->id, $a)) {
                        $a[] = $apartment->id;
                    }
                }
            }
        }

        //Inserting in orderedApartments all the apartments in order
        $orderdApartments = [];
        if(count($a) > 0){
            foreach ($a as $id) {
                foreach ($apartments as $apartment) {
                    if ($apartment->id == $id) {
                        $orderdApartments[] = $apartment;
                    }
                }
            }
        }else{
            foreach ($apartments as $apartment) {
                    $orderdApartments[] = $apartment;
            }
        }

        if ($apartments->count() > 0) {
            return response()->json([
                'result' => $orderdApartments,
                'success' => true,
                'sponsor' => $a
            ]);
        } else {
            return response()->json([
                'success' => false,
                'message' => 'No apartments found within ' . $radius . ' km radius',
            ]);
        }
    }
}
