<?php

namespace App\Http\Controllers;

use App\Models\Apartment;
use App\Models\View;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;

class ViewController extends Controller
{
    public function index()
    {
        $apartments = Apartment::where('user_id', '=', Auth::user()->id)->get();
        $views = DB::table('views')
            ->join('apartments', 'views.apartment_id', '=', 'apartments.id')
            ->where('apartments.user_id', Auth::user()->id)
            ->select('views.*', 'apartments.title as apartment_title')
            ->get();



        return view('admin.views.index', ['views' => $views->toJson()]);
    }

    public function show(Apartment $apartment)
    {
        //
        $this->checkUser($apartment);
        $views = View::where('apartment_id', '=', $apartment->id)->get();
        return view('admin.views.show',  ['views' => $views->toJson()], compact('apartment',));
    }

    private function checkUser(Apartment $apartment)
    {
        if ($apartment->user_id !== Auth::user()->id) {
            abort(404);
        }
    }
}
