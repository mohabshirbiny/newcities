<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class ServiceCategory extends Model
{
    protected $fillable = ["name", "icon"];

    protected $appends = [
        "title_en",
        'title_ar',
        "image_path"
    ];

    public function services()
    {
        return $this->hasMany(Service::class, "service_category_id", "id");
    }

    public function getTitleEnAttribute()
    {
        return json_decode($this->name, true)['en'];
    }

    public function getTitleArAttribute()
    {
        return json_decode($this->name, true)['ar'];
    }

    public function getImagePathAttribute()
    {
        $imageUrl = url('images/service_files/' . $this->icon);
        $imageUrl = url('public/images/service_files/' . $this->icon);
        return $imageUrl;
    }
}
