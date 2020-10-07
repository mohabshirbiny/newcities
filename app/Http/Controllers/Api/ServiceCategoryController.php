<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\ServiceCategory;
use Illuminate\Http\Request;

class ServiceCategoryController extends Controller
{
    public function getAll()
    {
        $records = ServiceCategory::all();
        return APIResponseController::respond(1, [], ["services" => $records], 200);
    }

    public function getOne($id)
    {
        $details = ServiceCategory::with("services")->find($id);
        return APIResponseController::respond(1, [], ["details" => $details], 200);
    }
}
