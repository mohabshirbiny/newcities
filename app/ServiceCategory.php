<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class ServiceCategory extends Model
{
    protected $fillable = ["name", "icon",'parent_id'];

    protected $appends = [
        "title_en",
        'title_ar',
        "image_path",
        "services_count"
    ];

    public function services()
    {
        return $this->hasMany(Service::class, "service_category_id", "id");
    }

    public function getServicesCountAttribute()
    {
        return $this->services()->count();
    }
    
    public function getTitleEnAttribute()
    {
        return json_decode($this->name, true)['en'];
    }

    public function getTitleArAttribute()
    {
        return json_decode($this->name, true)['ar'];
    }

    public function service_category_parent()
    {
        return $this->belongsTo(ServiceCategory::class, "parent_id", "id");
    }

    public function service_category_children()
    {
        return $this->hasMany(ServiceCategory::class, "parent_id", "id");

    }

    public function getImagePathAttribute()
    {
        $imageUrl = url('images/service_category_files/' . $this->icon);
        $imageUrl = url('public/images/service_category_files/' . $this->icon);
        return $imageUrl;
    }
}
