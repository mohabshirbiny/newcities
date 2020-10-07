<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class ServiceCategory extends Model
{
    protected $fillable = ["title_en", "title_ar", "icon"];

    public function services()
    {
        return $this->hasMany(Service::class, "service_category_id", "id");
    }
}
