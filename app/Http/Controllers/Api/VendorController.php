<?php
namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Vendor;

class VendorController extends Controller
{
    public function getAll()
    {
        $records = Vendor::with("vendor_category")->get();
        return APIResponseController::respond(1, [], ["vendors" => $records], 200);
    }

    public function getOne($id)
    {
        $details = Vendor::with("vendor_category")->find($id);
        return APIResponseController::respond(1, [], ["details" => $details], 200);
    }
}
