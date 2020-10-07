<?php

namespace App\Http\Controllers\Api;

use App\CityDistrict;
use App\City;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;

class CityDistrictController extends Controller
{
    public function getAll($city_id)
    {   
        if(!City::find($city_id)){
            return APIResponseController::respond(0,'no city with this id',[],404); 
        }

        $records = CityDistrict::where('city_id',$city_id)->get();

        return APIResponseController::respond(1,'distircts retreived successfully',["distircts" => $records],200); 
    }

    public function getOne($id)
    {
        $details = CityDistrict::with("city")->find($id);
        
        return APIResponseController::respond(1,'distirct retreived successfully',["distircts" => $details],200); 
    }
}
