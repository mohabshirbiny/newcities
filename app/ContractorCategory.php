<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class ContractorCategory extends Model
{
    protected $fillable = ["name", "icon"];

    protected $appends = ["name_ar", "name_en",'icon_path'];

    public function getNameEnAttribute()
    {
        return json_decode($this->name)->en;
    }

    public function getNameArAttribute()
    {
        return json_decode($this->name)->ar;
    }

    public function getIconPathAttribute(){
        $imageUrl = url('public/images/events_categories_files/'.$this->icon);
        return $imageUrl;
    }
}
