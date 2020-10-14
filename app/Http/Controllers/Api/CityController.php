<?php

namespace App\Http\Controllers\Api;

use App\City;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;

class CityController extends Controller
{
    public function getAll()
    {
        $records = City::with("districts")->get();
        return APIResponseController::respond(1,'',["cities" => $records],200); 
    }

    public function getOne($id)
    {
        if(!City::find($id)){
            return APIResponseController::respond(0,'no city with this id',[],404); 
        }

        $details = City::with("districts",'sponsors')->find($id);
        
        return APIResponseController::respond(1,'',["city" => $details],200); 
    }
}
