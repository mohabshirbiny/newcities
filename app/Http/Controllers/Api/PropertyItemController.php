<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\PropertyItem;

class PropertyItemController extends Controller
{
    public function getAll()
    {
        $records = PropertyItem::get();
        return APIResponseController::respond(1, [], ["properties" => $records], 200);
    }

    public function getOne($id)
    {
        $details = PropertyItem::find($id);
        return APIResponseController::respond(1, [], ["details" => $details], 200);
    }
}
