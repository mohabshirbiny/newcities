<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class EventCategory extends Model
{
    protected $fillable = [
        "title_en", "title_ar", "icon",
    ];

    public function events()
    {
        return $this->hasMany(Event::class, "event_category_id", "id");
    }
}
