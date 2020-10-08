<?php

namespace App\Http\Controllers\Api;

use App\Compound;
use App\Http\Controllers\Controller;

class CompoundController extends Controller
{
    public function getAll()
    {
        $records = Compound::get();
        return APIResponseController::respond(1, [], ["compounds" => $records], 200);
    }

    public function getOne($id)
    {
        $details = Compound::find($id);
        return APIResponseController::respond(1, [], ["details" => $details], 200);
    }
}
