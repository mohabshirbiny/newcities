<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Developer extends Model
{
    protected $fillable = ["name", "logo", "cover", "gallery", "location_url", "about", "contact_details", "social_media"];

}
