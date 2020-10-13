<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class VendorCategory extends Model
{
    protected $fillable = ["name", "icon",'parent_id'];

    protected $appends = [
        "name_en" ,
        'name_ar',
        'image_path',
        'vendors_count',
    ];

    public function vendors()
    {
        return $this->hasMany(Vendor::class, "vendor_category_id", "id");
    }

    public function getVendorsCountAttribute()
    {
        return $this->vendors()->count();
    }

    public function getNameEnAttribute()
    {
        return json_decode($this->name,true)['en'];
    }

    public function getNameArAttribute()
    {
        return json_decode($this->name,true)['ar'];
    }

    public function vendor_category_parent()
    {
        return $this->belongsTo(VendorCategory::class, "parent_id", "id");
    }

    public function vendor_category_children()
    {
        return $this->hasMany(VendorCategory::class, "parent_id", "id");

    }

    public function getImagePathAttribute()
    {
        $imageUrl = url('images/vendor_category_files/' . $this->icon);
        $imageUrl = url('public/images/vendor_category_files/' . $this->icon);
        return $imageUrl;
    }
}
