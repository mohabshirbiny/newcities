<?php

namespace App\Http\Controllers\Api;

use App\EventOrganizer;
use App\Http\Controllers\Controller;

class EventOrganizerController extends Controller
{
    public function getAll()
    {
        $records = EventOrganizer::all();
        return APIResponseController::respond(1, [], ["event_organizers" => $records], 200);
    }

    public function getOne($id)
    {
        $details = EventOrganizer::with("events")->find($id);
        return APIResponseController::respond(1, [], ["details" => $details], 200);
    }
}
