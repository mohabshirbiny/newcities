<?php

namespace App\Http\Controllers\Api;

use App\EventSponsor;
use App\Http\Controllers\Controller;

class EventSponsorController extends Controller
{
    public function getAll()
    {
        $records = EventSponsor::all();
        return APIResponseController::respond(1, [], ["event_sponsors" => $records], 200);
    }

    public function getOne($id)
    {
        $details = EventSponsor::with("events")->find($id);
        return APIResponseController::respond(1, [], ["details" => $details], 200);
    }
}
