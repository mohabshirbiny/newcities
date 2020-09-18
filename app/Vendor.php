<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Vendor extends Model
{
    protected $fillable = ["vendor_category_id", "title_en", "title_ar", "logo",
        "cover", "gallery", "location_url", "about_en", "about_ar", "contact_details", "social_media", "city_id",
        "district", "parent_id", "is_parent"];

    public function vendor_category()
    {
        return $this->belongsTo(VendorCategory::class);
    }
}
