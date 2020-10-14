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
        "gallery",
    ];

    protected $appends = ['logo_path','cover_path','city_gallery'];


    public function districts(){
        return $this->hasMany(CityDistrict::class);
    }

    public function developers()
    {
        return $this->belongsToMany(Developer::class,'city_developer','city_id','developer_id');
    }

    public function contractors()
    {
        return $this->belongsToMany(Contractor::class,'city_contractor','city_id','contractor_id');
    }
    
    public function sponsors()
    {
        return $this->belongsToMany(EventSponsor::class,'city_sponsor','city_id','sponsor_id');
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

    public function getCityGalleryAttribute(){
        $gallery = json_decode($this->gallery,true);
        if(!$gallery) return (object)[];
        foreach ($gallery as $type => $files) {
            if ($type == 'image') {
                foreach ($files as $image) {
                    $new_gallery['images'][] = url('public/images/city_files/'.$image);
                }
            } 
            if ($type == 'youtube_video') {
                foreach ($files as $youtube_video) {
                    $new_gallery['youtube_video'][] = $youtube_video;
                }
            } 
            if ($type == 'video') {
                // dd($files);
                $i = 0;
                foreach ($files as $video) {
                    $new_gallery['videos'][$i]['video'] = url('public/videos/city_files/'.$video['video']);
                    $new_gallery['videos'][$i]['thumbnail'] = url('public/videos/city_files/'.$video['thumbnail']);
                    $i++;
                }
            } 
        }
        return $new_gallery;
    }
}
