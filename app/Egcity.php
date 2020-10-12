<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Egcity extends Model
{
    // protected $table = 'eg_cities';

    public function governorate()
    {
        return $this->belongsTo(Governorate::class,'gov_id');
    }
}
