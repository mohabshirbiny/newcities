<?php

namespace App\Http\Controllers\Admin;

use App\Events\MobileReceiveMessage;
use App\Http\Controllers\Controller;
use App\Message;
use Illuminate\Http\Request;

class ChatController extends Controller
{
    public function send(Request $request)
    {
        $this->validate($request, [
            "customer_id" => "required",
            "content" => "required",
            "is_read" => "required",
        ]);

        $message = Message::create([
            "customer_id" => $request->customer_id,
            "admin_id" => null,
            "content" => $request->content,
            "is_read" => 0,
        ]);

        event(new MobileReceiveMessage($message));
    }
}
