<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class VendorCategory extends Model
{
    protected $fillable = ["name", "icon"];

    public function vendors()
    {
        return $this->hasMany(Vendor::class, "vendor_category_id", "id");
    }
}
