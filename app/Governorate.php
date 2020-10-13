<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Governorate extends Model
{
    public function cities()
    {
        return $this->hasMany(Egcity::class,'gov_id');
    }
}
