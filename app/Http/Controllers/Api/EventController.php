<?php

namespace App\Http\Controllers\Api;

use App\Event;
use App\Http\Controllers\Controller;

class EventController extends Controller
{
    public function getAll()
    {
        $records = Event::with("category")->with("organizer")->with("sponsor")->get();
        return APIResponseController::respond(1, [], ["events" => $records], 200);
    }

    public function getOne($id)
    {
        $details = Event::with("category")->with("organizer")->with("sponsor")->find($id);
        return APIResponseController::respond(1, [], ["details" => $details], 200);
    }
}
