<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class VendorCategory extends Model
{
    protected $fillable = ["name", "icon"];

    protected $appends = [
        "name_en" ,
        'name_ar',
    ];

    public function vendors()
    {
        return $this->hasMany(Vendor::class, "vendor_category_id", "id");
    }

    public function getNameEnAttribute()
    {
        return json_decode($this->name,true)['en'];
    }

    public function getNameArAttribute()
    {
        return json_decode($this->name,true)['ar'];
    }
}
