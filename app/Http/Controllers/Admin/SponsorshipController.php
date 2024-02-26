<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Http\Requests\StoreSponsorshipRequest;
use App\Models\Apartment;
use App\Models\ApartmentSponsorship;
use App\Models\Sponsorship;
use Carbon\Carbon;
use Illuminate\Http\Request;

class SponsorshipController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index(Request $request)
    {
        $selectApartment = Apartment::where("slug", "=", $request->apartment)->get();
        $apartment = $selectApartment[0];
        $sponsorships = ApartmentSponsorship::where("apartment_id", "=", $apartment->id)->get();
        $typeSponsorship = Sponsorship::all();
        return view("admin.sponsorships.index", compact("sponsorships", "apartment", "typeSponsorship"));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create(Request $request)
    {
        $apartmentSelected = Apartment::where("slug", "=", $request->apartment)->get();
        $apartment = $apartmentSelected[0];
        $sponsorship = Sponsorship::all();
        return view("admin.sponsorships.create", compact('apartment', 'sponsorship'));
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(StoreSponsorshipRequest $request)
    {
        //Form data
        $form_data = $request->all();
        //Objects
        $apartment_sponsorship = new ApartmentSponsorship;
        $sponsorship = Sponsorship::where("id", $form_data["sponsorship_id"])->get();
        $apartment = Apartment::where("id", $form_data["apartment_id"])->get();
        $allSponsorships = ApartmentSponsorship::where("apartment_id", $apartment[0]->id)->get();

        //sponsorship selected by the user
        $selectedSponsorship = $sponsorship[0];
        //Merging the date and the time selected
        $date = $form_data['start_date'];
        $time = $form_data['start_time'];
        $startDate = date('Y-m-d H:i:s', strtotime("$date $time"));
        //Calculation of expiration date
        $expirationDate = Carbon::parse($startDate)->addDays($selectedSponsorship->duration / 24);

        //Check if the start date is between the start and expiration date of another sponsorship
        $flag = true;

       

        if($startDate < Carbon::now()){
            $flag = false;
        }

        foreach ($allSponsorships as $checkSponsorship) {
            $from = $checkSponsorship->start_date;
            $to = $checkSponsorship->expiration_date;
            $check = $startDate;
            if (($check >= $from) && ($check <= $to)) {
                $flag = false;
            }
        }

        //Inserting the new sponsorship_apartment row in the table
        if ($flag) {
            $apartment_sponsorship->start_date = $startDate;
            $apartment_sponsorship->expiration_date = $expirationDate;
            $apartment_sponsorship->sponsorship_id = $selectedSponsorship->id;
            $apartment_sponsorship->apartment_id = $form_data['apartment_id'];
            $apartment_sponsorship->save();

            return redirect()->route('sponsorships.index', ['apartment' => $apartment[0]->slug])->with('message', 'Successfull purchase!');
        }
        return redirect()->route('sponsorships.index', ['apartment' => $apartment[0]->slug])->with('error', 'Something went wrong, please check the dates');
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
    public function destroy(ApartmentSponsorship $sponsorship)
    {

        $apartmentData = Apartment::where("id", $sponsorship->apartment_id)->get();
        $apartment=$apartmentData[0];
        $sponsorship->delete();

        return redirect()->route('sponsorships.index', ['apartment' => $apartment->slug])->with('message', 'Sponsorship deleted!');
    }
}
