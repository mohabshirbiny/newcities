<?php

namespace App\Http\Controllers\Api;

use App\Events\MobileReceiveMessage;
use App\Http\Controllers\Controller;
use App\Message;
use Illuminate\Http\Request;

class MessageController extends Controller
{
    public function getHistory()
    {
        $user = auth('api')->user();

        $messages = Message::where("customer_id", $user->id)->get();

        return APIResponseController::respond(1, '', ["messages" => $messages], 200);
    }


    public function sendMessage(Request $request)
    {
        $customer = auth('api')->user();

        $message = Message::create([
            "customer_id" => $customer->id,
            "admin_id" => null,
            "content" => $request->content,
            "sender_type" => 1,
            "is_read" => 0,
        ]);

        event(new MobileReceiveMessage($message));

        return APIResponseController::respond(1, '', ["messages" => $customer->messages], 200);
    }
}
