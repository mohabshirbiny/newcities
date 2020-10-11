<?php

namespace App\Http\Controllers\Api;

use App\Developer;
use App\Http\Controllers\Controller;

class DeveloperController extends Controller
{
    public function getAll()
    {
        $records = Developer::get();
        return APIResponseController::respond(1, [], ["developers" => $records], 200);
    }

    public function getOne($id)
    {
        $details = Developer::find($id);
        return APIResponseController::respond(1, [], ["details" => $details], 200);
    }
}
