<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Compound extends Model
{
    protected $fillable = ["city_id", "name", "logo",
        "cover", "gallery", "location_url", "about", "contact_details", "social_media"];
}
