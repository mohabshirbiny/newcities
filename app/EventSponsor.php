<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class EventSponsor extends Model
{
    protected $fillable = [
        "title_en", "title_ar", "logo", "phone", "website",
    ];

    public function events()
    {
        return $this->hasMany(Event::class, "event_sponsor_id", "id");
    }
}
