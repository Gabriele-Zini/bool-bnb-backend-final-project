<?php

namespace App\Http\Controllers;

use App\Models\Apartment;
use App\Models\View;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class ViewController extends Controller
{
    public function index()
    {
        $views = View::all();
        $apartments = Apartment::where('user_id', '=', Auth::user()->id)->get();
        foreach ($views as $view) {
            foreach ($apartments as $apartment) {
                if ($view->apartment_id === $apartment->id) {
                    $view['apartment_title'] = $apartment->title;
                }
            }
        };
        return view('admin.views.index', ['views' => $views->toJson()]);
    }

    public function show(Apartment $apartment)
    {
        //
        $this->checkUser($apartment);
        $views = View::where('apartment_id', '=', $apartment->id)->get();
        return view('admin.views.show',  ['views' => $views->toJson()], compact('apartment', ));
    }

    private function checkUser(Apartment $apartment)
    {
        if ($apartment->user_id !== Auth::user()->id) {
            abort(404);
        }
    }

}
