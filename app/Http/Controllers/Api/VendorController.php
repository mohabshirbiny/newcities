<?php
namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Vendor;

class VendorController extends Controller
{
    public function getAll()
    {
        $records = Vendor::get();
        return APIResponseController::respond(1, '', ["vendors" => $records], 200);
    }

    public function getOne($id)
    {
        $details = Vendor::find($id);
        return APIResponseController::respond(1, 'vendor data', ["vendor" => $details], 200);
    }
}
