<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Contractor extends Model
{
    protected $fillable = ["contractor_category_id", "name", "logo",
        "cover", "gallery", "location_url", "about", "contact_details", "social_media"];
}
