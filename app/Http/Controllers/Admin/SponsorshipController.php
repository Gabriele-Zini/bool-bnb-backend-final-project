<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Apartment;
use App\Models\ApartmentSponsorship;
use App\Models\Sponsorship;
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
    public function store(Request $request)
    {
        dd($request->all());
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
}
