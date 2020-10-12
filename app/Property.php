<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Property extends Model
{
    protected $fillable = [
        "name", "city_id", "compound_id", "developer_id", "property_type_id", "attachments", "cover", "gallery", "about", "use_facilities"
    ];
}
