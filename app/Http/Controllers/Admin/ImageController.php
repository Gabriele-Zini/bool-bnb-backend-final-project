<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Http\Requests\StoreImageRequest;
use App\Models\Apartment;
use App\Models\Image;
use Illuminate\Http\Request;

class ImageController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index(Request $request)
    {
        $apartmentSlug = $request->input('apartment');

        $apartment = Apartment::where('slug', $apartmentSlug)->firstOrFail();

        $images = $apartment->images;

        return view('admin.images.index', compact('images', 'apartment'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {

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
    public function update(Image $image, StoreImageRequest $storeImageRequest)
    {

    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Image $image, Apartment $apartment)
    {

        $apartment=Apartment::where('id', $image->apartment_id)->get();
        dd($apartment, $image);

        /* $image->delete(); */
        return redirect()->route('images.index', ['apartment' => $apartment->slug]);
    }
}
