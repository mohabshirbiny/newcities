<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class CityDistrict extends Model
{
    protected $fillable = [
        "name_ar",
        "name_en",
        "city_id",
        "location_url",
    ];

    public function city()
    {
        return $this->belongsTo(City::class);
    }
}
