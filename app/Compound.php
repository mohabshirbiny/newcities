<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Compound extends Model
{
    protected $fillable = ["city_id", "name", "logo",
        "cover", "gallery", "location_url", "about", "contact_details", "social_media"];

    protected $appends = [
        "name_en" ,
        'name_ar',
        "about_en" ,
        'about_ar',
        'logo_path',
        'cover_path',
    ];

    public function getLogoPathAttribute(){
        $imageUrl = url('images/compound_files/'.$this->logo);
        $imageUrl = url('public/images/compound_files/'.$this->logo);
        return $imageUrl;
    }

    public function getCoverPathAttribute(){
        $imageUrl = url('images/compound_files/'.$this->cover);
        $imageUrl = url('public/images/compound_files/'.$this->cover);
        return $imageUrl;
    }

    public function getNameEnAttribute()
    {
        return json_decode($this->name,true)['en'];
    }

    public function getNameArAttribute()
    {
        return json_decode($this->name,true)['ar'];
    }

    public function getAboutEnAttribute()
    {
        return json_decode($this->about,true)['en'];
    }

    public function getAboutArAttribute()
    {
        return json_decode($this->about,true)['ar'];
    }
}
