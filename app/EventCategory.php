<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class EventCategory extends Model
{
    protected $fillable = [
        "title_en", "title_ar", "icon",
    ];

    protected $appends = ['icon_path'];

    public function events()
    {
        return $this->hasMany(Event::class, "event_category_id", "id");
    }

    public function getIconPathAttribute(){
        $imageUrl = url('public/images/events_categories_files/'.$this->icon);
        return $imageUrl;
    }
}
