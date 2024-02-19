<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Apartment;
use App\Models\Service;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Http;
use GuzzleHttp\Client;
use Illuminate\Support\Facades\Auth;

class ApartmentController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        // $perPage = 10;
        $apartments = Apartment::where('user_id', '=', Auth::user()->id)->get();

        return view('admin.apartments.index', compact('apartments'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        $services = Service::all();
        $client = new Client(['verify' => false]);
        $response = $client->get('https://restcountries.com/v3.1/all');
        $rows = json_decode($response->getBody());
        $countryCodes = [];
        if ($response) {

            foreach ($rows as $row) {

                $countryCodes[] = [
                    'code' => $row->cca3,
                    'name' => $row->name->common
                ];
            }
        }


        usort($countryCodes, function ($a, $b) {
            return strcmp($a['name'], $b['name']);
        });

        return view('admin.apartments.create', compact('services', 'countryCodes'));
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $form_data = $request->all();
        $apartment = new Apartment();
        $apartment->fill($form_data);
        $apartment->user_id = Auth::user()->id;



        $client = new Client(['verify' => false]);
        $response = $client->get("https://api.tomtom.com/search/2/structuredGeocode.json?key=HAMFczyVGd30ClZCfYGP9To9Y18u6eq7&countryCode=" . urlencode($request->country) . "&streetName=" . urlencode($request->street_name) . "&municipality=" . urlencode($request->city) . "&streetNumber=" . urlencode($request->street_number));
        $rows = json_decode($response->getBody());
        dd($rows);

        function controlParams($rows, $request)
        {
            if (trim(strtolower($request->street_name)) === trim(strtolower($rows->results[0]->address->streetName)) && trim(strtolower($request->street_number)) === trim(strtolower($rows->results[0]->address->streetNumber)) && trim(strtolower($request->city)) === trim(strtolower($rows->results[0]->address->municipality)) && trim(strtolower($request->postal_code)) == trim(strtolower($rows->results[0]->address->postalCode))) {
                dd(trim(strtolower($rows->results[0]->address->streetName)), trim(strtolower($request->street_name)));
                return true;
            } else {
                 dd(trim(strtolower($rows->results[0]->address->streetName)), trim(strtolower($request->street_name)));
                return false;
            }
        }



        if (count($rows->results) > 0 &&  $rows->results[0]->type === "Point Address" &&  controlParams($rows, $request) /* && trim(strtolower($request->postal_code)) == trim(strtolower($rows->results[0]->address->postalCode)) */) {
            $apartment->latitude = $rows->results[0]->position->lat;
            $apartment->longitude = $rows->results[0]->position->lon;

            /*  $apartment->postal_code=$rows->results[0]->address->postalCode; */
        } else {
            return back()->with('error', 'Position not found');
        }

        $apartment->save();
        if ($request->has('services'))
            $apartment->services()->attach($request->services);
        return redirect(route('apartments.index'));
    }

    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(string $id)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $id)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        //
    }

    public function controlParams($rows, $request)
    {
        if (trim(strtolower($request->street_name)) === trim(strtolower($rows->results[0]->address->streetName)) && trim(strtolower($request->street_number)) === trim(strtolower($rows->results[0]->address->streetNumber)) && trim(strtolower($request->city)) === trim(strtolower($rows->results[0]->address->municipality)) && trim(strtolower($request->postal_code)) == trim(strtolower($rows->results[0]->address->postalCode))) {
            return true;
        } else {
            return false;
        }
    }
}
