<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Apartment;
use App\Models\Message;

class MessageController extends Controller
{
public function sendMessage(Request $request, Apartment $apartment) {
    $request->validate([
        'message_content' => 'required|string|max:255',
        'email' => 'required|email',
        'name' => 'required|string',
        'lastname' => 'required|string',
    ]);

    $message = new Message();
    $message->message_content = $request->input('message_content');
    $message->email = $request->input('email');
    $message->name = $request->input('name');
    $message->lastname = $request->input('lastname');
    $message->apartment_id = $apartment->id;
    $message->save();

    return response()->json(['message' => 'Messaggio inviato con successo']);
}
}
