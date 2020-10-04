<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class City extends Model
{
    protected $fillable = [
        "name_ar",
        "name_en",
        "logo",
        "cover",
        "contact_details",
        "social_links",
        "about_ar",
        "about_en",
        "location_url",
    ];
}
