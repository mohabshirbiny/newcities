<?php

namespace App\Http\Controllers\Admin;

use App\Events\MobileReceiveMessage;
use App\Http\Controllers\Controller;
use App\Message;
use Illuminate\Http\Request;

class MessageController extends Controller
{
    public function getAll()
    {
        $messages = Message::where('admin_id', null)
            ->with('customer')
            ->groupBy('customer_id')->paginate(20);

        return view("admin.chat.index", compact("messages"));
    }

    public function history($customer_id)
    {
        $messages = Message::where("customer_id", $customer_id)->get();
        $html = "";
        foreach ($messages as $one_message) {
            if ($one_message->sender_type == 1) { // customer
                $html .= "<div class='direct-chat-msg'>
                            <div class='direct-chat-infos clearfix'>
                                <span class='direct-chat-name float-left'>{$one_message->customer->name}</span>
                                <span class='direct-chat-timestamp float-right'>{$one_message->created_at}</span>
                            </div>
                            <div class='direct-chat-text'>$one_message->content</div>
                        </div>";
            } else {
                $html .= "<div class='direct-chat-msg right'>
                            <div class='direct-chat-infos clearfix'>
                                <span class='direct-chat-name float-right'>Admin</span>
                                <span class='direct-chat-timestamp float-left'>{$one_message->created_at}</span>
                            </div>
                            <div class='direct-chat-text'>$one_message->content</div>
                        </div>";
            }
        }
        return $html;
    }

    public function send(Request $request)
    {
        $this->validate($request, [
            "customer_id" => "required",
            "content" => "required",
        ]);

        $message = Message::create([
            "customer_id" => $request->customer_id,
            "admin_id" => null,
            "content" => $request->content,
            "sender_type" => 2,
            "is_read" => 0,
        ]);

        event(new MobileReceiveMessage($message));

        $html = $this->history($request->customer_id);

        return $html;
    }

    public function receive(Request $request)
    {
        $this->validate($request, [
            "customer_id" => "required",
            "content" => "required",
        ]);

        $message = Message::create([
            "customer_id" => $request->customer_id,
            "admin_id" => null,
            "content" => $request->content,
            "sender_type" => 1,
            "is_read" => 0,
        ]);

    }
}
