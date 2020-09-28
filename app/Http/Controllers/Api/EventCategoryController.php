<?php

namespace App\Http\Controllers\Api;

use App\EventCategory;
use App\Http\Controllers\Controller;

class EventCategoryController extends Controller
{
    public function getAll()
    {
        $records = EventCategory::all();
        return APIResponseController::respond(1, [], ["event_categories" => $records], 200);
    }

    public function getOne($id)
    {
        $details = EventCategory::with("events")->find($id);
        return APIResponseController::respond(1, [], ["details" => $details], 200);
    }
}
