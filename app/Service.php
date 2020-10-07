<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Service extends Model
{
    public function service_category()
    {
        return $this->belongsTo(ServiceCategory::class);
    }
}
