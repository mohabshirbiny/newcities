<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Service;
use Illuminate\Http\Request;

class ServiceController extends Controller
{
    public function getAll()
    {
        $records = Service::with("service_category")->get();
        return APIResponseController::respond(1, [], ["services" => $records], 200);
    }

    public function getOne($id)
    {
        $details = Service::with("service_category")->find($id);
        return APIResponseController::respond(1, [], ["details" => $details], 200);
    }
}
