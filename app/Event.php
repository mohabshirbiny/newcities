<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Event extends Model
{
    protected $fillable = [
        "title_en", "title_ar", "event_category_id", "date_from", "date_to", "time_from", "time_to",
        "contact_details", "location_url", "city_id", "city_location", "address", "cover", "gallery",
        "event_organizer_id", "event_sponsor_id", "about_en", "about_ar",
    ];

    public function category()
    {
        return $this->belongsTo(EventCategory::class, "event_category_id", "id");
    }

    public function organizer()
    {
        return $this->belongsTo(EventOrganizer::class, "event_organizer_id", "id");
    }

    public function sponsor()
    {
        return $this->belongsTo(EventSponsor::class, "event_sponsor_id", "id");
    }
}
