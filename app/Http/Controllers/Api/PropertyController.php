<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Property;

class PropertyController extends Controller
{
    public function getAll()
    {
        $query = Property::query();

        if (request()->compound_id && request()->compound_id != "") {
            $query->where("compound_id", request()->compound_id);
        }

        $records = $query->get();
        
        return APIResponseController::respond(1, "Properties", ["properties" => $records], 200);
    }

    public function getOne($id)
    {
        $details = Property::find($id);
        return APIResponseController::respond(1, "Property details", ["details" => $details], 200);
    }
}
