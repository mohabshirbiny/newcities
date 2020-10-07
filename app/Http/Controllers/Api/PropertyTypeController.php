<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\PropertyType;

class PropertyTypeController extends Controller
{
    public function getAll()
    {
        $records = PropertyType::get();
        return APIResponseController::respond(1, [], ["properties" => $records], 200);
    }

    public function getOne($id)
    {
        $details = PropertyType::find($id);
        return APIResponseController::respond(1, [], ["details" => $details], 200);
    }
}
