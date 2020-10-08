<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class City extends Model
{
    protected $fillable = [
        "name_ar",
        "name_en",
        "logo",
        "cover",
        "contact_details",
        "social_links",
        "about_ar",
        "about_en",
        "location_url",
    ];

    protected $appends = ['logo_path','cover_path'];


    public function districts(){
        return $this->hasMany(CityDistrict::class);
    }

    public function getLogoPathAttribute(){
        $imageUrl = url('images/city_files/'.$this->logo);
        $imageUrl = url('public/images/city_files/'.$this->logo);
        return $imageUrl;
    }

    public function getCoverPathAttribute(){
        $imageUrl = url('images/city_files/'.$this->cover);
        $imageUrl = url('public/images/city_files/'.$this->cover);
        return $imageUrl;
    }

    public function getContactDetailsAttribute($value){        
        return unserialize($value);
    }

    public function getsocialLinksAttribute($value){        
        return unserialize($value);
    }
}
