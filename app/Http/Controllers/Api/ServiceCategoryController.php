<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\ServiceCategory;
use Illuminate\Http\Request;

class ServiceCategoryController extends Controller
{
    public function getAll()
    {
        $records = ServiceCategory::withCount("services")->get();
        return APIResponseController::respond(1, "Services categories", ["services" => $records], 200);
    }

    public function getOne($id)
    {
        $details = ServiceCategory::with("services")->find($id);
        return APIResponseController::respond(1, "Services categories", ["details" => $details], 200);
    }
}
