<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Vendor extends Model
{
    protected $fillable = ["vendor_category_id", "name", "logo",
        "cover", "gallery", "location_url", "about", "contact_details", "social_media", "city_id",
        "district_id", "parent_id", "is_parent"];

    public function vendor_category()
    {
        return $this->belongsTo(VendorCategory::class);
    }
}
