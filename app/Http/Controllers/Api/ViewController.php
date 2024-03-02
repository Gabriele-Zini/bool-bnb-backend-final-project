<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\Apartment;
use App\Models\View;
use Illuminate\Http\Request;

class ViewController extends Controller
{
    public function store(Request $request, Apartment $apartment)
    {

        $data = $request->all();

        $view=new View();
        $view->user_ip=$data['user_ip'];
        $view->apartment_id= $data['apartment_id'];
        $view->fill($data);
        $view->save();

        return response()->json([
            'success'=> true,
            'data'=>$data,

        ]);
    }
}
