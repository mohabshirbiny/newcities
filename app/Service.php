<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Service extends Model
{
    protected $fillable = ["service_category_id", "name", "logo",
        "cover", "gallery", "location_url", "about", "contact_details", "social_media"];

    public function service_category()
    {
        return $this->belongsTo(ServiceCategory::class);
    }
}
