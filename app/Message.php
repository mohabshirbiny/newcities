<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Message extends Model
{
    protected $fillable = ["customer_id", "admin_id", "content", "is_read", "sender_type"];
    //
    public function customer()
    {
        return $this->belongsTo(Customer::class);
    }
}
