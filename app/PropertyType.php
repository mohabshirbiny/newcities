<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class PropertyType extends Model
{
    protected $fillable = ["name", "icon"];

    protected $appends = [
        "name_en",
        'name_ar',
        'icon_path',
    ];

    public function getIconPathAttribute()
    {
        $imageUrl = url('images/property_files/' . $this->icon);
        $imageUrl = url('public/images/property_files/' . $this->icon);
        return $imageUrl;
    }
    
    public function getNameEnAttribute()
    {
        return json_decode($this->name, true)['en'];
    }

    public function getNameArAttribute()
    {
        return json_decode($this->name, true)['ar'];
    }

}
