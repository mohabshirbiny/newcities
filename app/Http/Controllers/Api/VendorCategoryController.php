<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\VendorCategory;

class VendorCategoryController extends Controller
{
    public function getAll()
    {
        $records = VendorCategory::all();
        return APIResponseController::respond(1, [], ["vendors" => $records], 200);
    }

    public function getOne($id)
    {
        $details = VendorCategory::with("vendors")->find($id);
        return APIResponseController::respond(1, [], ["details" => $details], 200);
    }
}
