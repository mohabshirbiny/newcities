<?php

namespace App\Http\Controllers\Api;

use App\Contractor;
use App\Http\Controllers\Controller;

class ContractorController extends Controller
{
    public function getAll()
    {
        $records = Contractor::get();
        return APIResponseController::respond(1, [], ["contractors" => $records], 200);
    }

    public function getOne($id)
    {
        $details = Contractor::find($id);
        return APIResponseController::respond(1, [], ["details" => $details], 200);
    }
}
