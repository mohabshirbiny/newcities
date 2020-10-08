<?php

namespace App\Http\Controllers\Api;

use App\Facility;
use App\Http\Controllers\Controller;

class FacilityController extends Controller
{
    public function getAll()
    {
        $records = Facility::get();
        return APIResponseController::respond(1, [], ["facilities" => $records], 200);
    }

    public function getOne($id)
    {
        $details = Facility::find($id);
        return APIResponseController::respond(1, [], ["details" => $details], 200);
    }
}
