<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Http\Requests\StoreApartmentRequest;
use App\Http\Requests\StoreImageRequest;
use App\Http\Requests\UpdateApartmentRequest;
use App\Models\Apartment;
use App\Models\Apartment_info;
use App\Models\ApartmentSponsorship;
use App\Models\Service;
use App\Models\Image;
use App\Models\View;
use App\Models\Sponsorship;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Http;
use GuzzleHttp\Client;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Storage;

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
    public function store(StoreApartmentRequest $request,  StoreImageRequest $imageRequest)
    {
        $form_data = $request->validated();
        $imageData = $imageRequest->validated();

        $apartment = new Apartment();
        $apartment_infos = new Apartment_info();

        $apartment->fill($form_data);
        $apartment_infos->fill($form_data);

        // autentication
        $apartment->user_id = Auth::user()->id;

        // api tomtom get-request
        $client = new Client(['verify' => false]);
        $response = $client->get("https://api.tomtom.com/search/2/structuredGeocode.json?key=HAMFczyVGd30ClZCfYGP9To9Y18u6eq7&countryCode=" . urlencode($request->country_code) . "&streetName=" . urlencode($request->street_name) . "&municipality=" . urlencode($request->city) . "&streetNumber=" . urlencode($request->street_number));
        $rows = json_decode($response->getBody());


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
            foreach ($files as $key => $file) {
                $imageName = time() . '_' . $file->getClientOriginalName();
                $file->move(public_path("storage/image_path"), $imageName);

                $image = new Image([
                    'image_path' => $imageName,
                    'apartment_id' => $apartment->id,
                    'cover_image' => ($key === 0) ? 1 : 0,
                ]);
                $image->save();
            }
        }

        if ($request->has('services'))
            $apartment->services()->attach($request->services);
        return redirect(route('apartments.index'))->with('message', 'New apartment created');
    }

    /**
     * Display the specified resource.
     */
    public function show(Apartment $apartment)
    {
        $this->checkUser($apartment);
        // $sponsorship_active = Apartment::where('id', '=', $apartment->id)->where('expiration_date', '>', Carbon::now())->get();
        // dd($apartment->sponsorships);
        $sponsorship_active = DB::table('apartments')
            ->join('apartment_sponsorship', 'apartments.id', '=', 'apartment_sponsorship.apartment_id')
            ->where('apartment_sponsorship.apartment_id', '=', $apartment->id)
            ->where('expiration_date', '>', Carbon::now())
            ->get();

        if (count($sponsorship_active) > 0) {
            $sponsorship_type = Sponsorship::where('id', '=', $sponsorship_active[0]->sponsorship_id)->get();
        } else {
            $sponsorship_type = 0;
        }

        return view('admin.apartments.show', compact('apartment', 'sponsorship_active', 'sponsorship_type'));
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
    public function update(UpdateApartmentRequest $request, Apartment $apartment, StoreImageRequest $imageRequest, Image $image)
    {
        $form_data = $request->validated();
        $imageData = $imageRequest->validated();

        $apartment->update($form_data);
        $apartment->apartment_info->update($form_data);

        // delete images
        if ($request->has('images')) {
            $selectedImages = $request->input('images');

            foreach ($selectedImages as $imageId) {
                $image = Image::find($imageId);

                if ($image && $image->image_path) {
                    Storage::delete('image_path/' . $image->image_path);
                }
            }

            Image::whereIn('id', $selectedImages)->delete();
        }

        // images storing
        if ($request->hasFile("image_path")) {
            $files = $request->file("image_path");
            foreach ($files as $file) {
                $imageName = time() . '_' . $file->getClientOriginalName();
                $file->move(public_path("storage/image_path"), $imageName);

                $image = new Image([
                    'image_path' => $imageName,
                    'apartment_id' => $apartment->id
                ]);
                $image->save();
            }
        }

        if ($request->has('services')) {
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
        return redirect()->route('apartments.index')->with('message', 'you have deleted ' . $apartment->title);
    }

    private function checkUser(Apartment $apartment)
    {
        if ($apartment->user_id !== Auth::user()->id) {
            abort(404);
        }
    }
}
