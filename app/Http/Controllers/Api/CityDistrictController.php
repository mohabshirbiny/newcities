<?php

namespace App\Http\Controllers;

use App\CityDistrict;
use Illuminate\Http\Request;

class CityDistrictController extends Controller
{
    public function getAll()
    {
        $records = CityDistrict::all();
        return api_response(1, "Categories retreived successfully.", $records);
        return APIResponseController::respond(1,[],["cities" => $records],200); 
    }

    public function getOne($id)
    {
        $details = CityDistrict::with("city")->find($id);
        return api_response(1, "Category retreived successfully.", $details);
    }
}
