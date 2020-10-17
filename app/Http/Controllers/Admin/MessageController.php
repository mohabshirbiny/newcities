<?php

namespace App\Http\Controllers\Admin;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Message;

class MessageController extends Controller
{
    public function getAll()
    {
        $messages = Message::where('admin_id',null)
        ->with('customer')->get()
        ->groupBy('customer.name');
        // dd($messages);
        return $messages;
        # code...
    }
    
    public function store(Request $request)
    {
        dd($request->all());
        # code...
    }
}
