<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Property;

class PropertyController extends Controller
{
    public function getAll()
    {
        $records = Property::get();
        return APIResponseController::respond(1, [], ["properties" => $records], 200);
    }

    public function getOne($id)
    {
        $details = Property::find($id);
        return APIResponseController::respond(1, [], ["details" => $details], 200);
    }
}
