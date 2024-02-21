<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Http\Requests\StoreApartmentRequest;
use App\Http\Requests\UpdateApartmentRequest;
use App\Models\Apartment;
use App\Models\Apartment_info;
use App\Models\Service;
use App\Models\Image;
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
        return view('admin.apartments.create', compact('services'));
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(StoreApartmentRequest $request)
    {
        // dd($request);
        $form_data = $request->validated();

        $apartment = new Apartment();
        $apartment_infos = new Apartment_info();

        $apartment->fill($form_data);
        $apartment_infos->fill($form_data);

        $apartment->user_id = Auth::user()->id;



        $client = new Client(['verify' => false]);
        $response = $client->get("https://api.tomtom.com/search/2/structuredGeocode.json?key=HAMFczyVGd30ClZCfYGP9To9Y18u6eq7&countryCode=" . urlencode($request->country_code) . "&streetName=" . urlencode($request->street_name) . "&municipality=" . urlencode($request->city) . "&streetNumber=" . urlencode($request->street_number));
        $rows = json_decode($response->getBody());
        /* dd($rows); */


        if (count($rows->results) > 0) {
            $apartment->latitude = $rows->results[0]->position->lat;
            $apartment->longitude = $rows->results[0]->position->lon;
            $apartment->street_name = $rows->results[0]->address->streetName;
            $apartment->street_number = $rows->results[0]->address->streetNumber;
            $apartment->postal_code = $rows->results[0]->address->postalCode;
            $apartment->city = $rows->results[0]->address->municipality;
            $apartment->country = $rows->results[0]->address->country;
            $apartment->country_code = $rows->results[0]->address->countryCodeISO3;

        } else {
            return back()->with('error', 'Position not found');
        }

        $apartment->save();

        $apartment_infos->apartment_id = $apartment->id;
        $apartment_infos->save();

        // images storing
        if ($request->hasFile("image_path")) {
            $files = $request->file("image_path");
            foreach ($files as $file) {
                $imageName = time() . '_' . $file->getClientOriginalName();
                $file->move(public_path("storage/image_path/$apartment->slug"), $imageName);

                $image = new Image([
                    'image_path' => $imageName,
                    'apartment_id' => $apartment->id
                ]);
                $image->save();
            }
        }

        if ($request->has('services'))
            $apartment->services()->attach($request->services);
        return redirect(route('apartments.index'));

    }

    /**
     * Display the specified resource.
     */
    public function show(Apartment $apartment)
    {
        $this->checkUser($apartment);
        return view('admin.apartments.show', compact('apartment'));
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Apartment $apartment)
    {
        $services = Service::all();

        return view('admin.apartments.edit', compact('services', 'apartment'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(UpdateApartmentRequest $request, Apartment $apartment)
    {
        $form_data = $request->validated();

        $apartment->update($form_data);
        $apartment->apartment_info->update($form_data);

        // images storing
        if ($request->hasFile("image_path")) {
            $files = $request->file("image_path");
            foreach ($files as $file) {
                $imageName = time() . '_' . $file->getClientOriginalName();
                $file->move(public_path("storage/image_path/$apartment->slug"), $imageName);

                $image = new Image([
                    'image_path' => $imageName,
                    'apartment_id' => $apartment->id
                ]);
                $image->save();
            }
        }

        if($request->has('services')) {
            $apartment->services()->sync($request->input('services', []));
        }

        return redirect()->route('apartments.show', ['apartment' => $apartment->slug])->with('message', 'Apartment updated!');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Apartment $apartment)
    {
        $apartment->delete();
        return redirect()->route('apartments.index')->with('message', 'you have deleted '.$apartment->title);
    }

    private function checkUser(Apartment $apartment)
    {
        if ($apartment->user_id !== Auth::user()->id) {
            abort(404);
        }
    }
}
