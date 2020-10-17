<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Message;

class MessageController extends Controller
{
    public function getHistory()
    {
        $user = auth('api')->user();

        $messages = Message::where("customer_id", $user->id)->get();

        return APIResponseController::respond(1, '', ["messages" => $messages], 200);
    }
}
