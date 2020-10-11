<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class EventOrganizer extends Model
{
    protected $fillable = [
        "title_en", "title_ar", "logo", "phone", "website",
    ];

    protected $appends = ['logo_path'];

    public function events()
    {
        return $this->hasMany(Event::class, "event_organizer_id", "id");
    }

    public function getLogoPathAttribute(){
        $imageUrl = url('public/images/events_organizers_files/'.$this->logo);
        return $imageUrl;
    }
}
