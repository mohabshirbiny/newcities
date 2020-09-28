<?php

namespace App\Http\Controllers\Api;

use App\City;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;

class CityController extends Controller
{
    public function getAll()
    {
        $records = City::with("city_districts")->get();
        return APIResponseController::respond(1,[],["cities" => $records],200); 
    }

    public function getOne($id)
    {
        $details = City::with("city_districts")->find($id);
        return APIResponseController::respond(1,[],["city" => $details],200); 
    }
}
