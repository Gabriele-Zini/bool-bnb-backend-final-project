<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Apartment;
use App\Models\Message;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class MessageController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index(Request $request)
    {
        $selectApartment = Apartment::where("slug", "=", $request->apartment)->get();
        $apartment = $selectApartment[0];
        $messages = Message::where("apartment_id", "=", $apartment->id)->get();
        return view("admin.messages.index", compact("messages", "apartment"));
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
        //
    }

    /**
     * Display the specified resource.
     */
    public function show(Message $message)
    {
        $message->readed = 1;
        $message->save();
        $selectApartment = Apartment::where("id", "=", $message->apartment_id)->get();
        $apartment = $selectApartment[0];
        return view("admin.messages.show", compact("message", "apartment"));
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
    public function destroy(Message $message)
    {
        $selectApartment = Apartment::where("id", "=", $message->apartment_id)->get();
        $apartment = $selectApartment[0];
        $message->delete();
        return redirect()->route('messages.index', ['apartment' => $apartment->slug])->with('message', 'you have deleted a message from '.$message->name." ".$message->lastname);
    }
}
