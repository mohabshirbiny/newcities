<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Vendor extends Model
{
    protected $fillable = ["vendor_category_id", "name", "logo",
        "cover", "gallery", "location_url", "about", "contact_details", "social_media", "city_id",
        "district_id", "parent_id", "is_parent"];

    protected $appends = [
        "name_en" ,
        'name_ar',
        "about_en" ,
        'about_ar',
        'logo_path',
        'cover_path',
        'vendor_gallery',
        'social_links',
    ];

    public function vendor_category()
    {
        return $this->belongsTo(VendorCategory::class);
    }

    public function jobs(){
        return $this->hasMany(Job::class);
    }

    public function getSocialLinksAttribute()
    {
        return json_decode($this->social_media,true);
    }

    public function getContactDetailsAttribute($value){        
        return json_decode($value,true);
    }

    public function getLogoPathAttribute(){
        $imageUrl = url('images/vandor_files/'.$this->logo);
        $imageUrl = url('public/images/vendor_files/'.$this->logo);
        return $imageUrl;
    }

    public function getCoverPathAttribute(){
        $imageUrl = url('images/vandor_files/'.$this->cover);
        $imageUrl = url('public/images/vendor_files/'.$this->cover);
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

    public function vendor_parent()
    {
        if ( $this->parent_id != null) {
            return Vendor::find($this->parent_id);
        }
        return null;
    }

    public function vendor_children()
    {
        if ( $this->is_parent == 1) {
            return Vendor::where('parent_id',$this->id)->get();
        }
        return null;
    }

    public function getVendorGalleryAttribute(){
        $gallery = json_decode($this->gallery,true);
        if(!$gallery) return (object)[];
        foreach ($gallery as $type => $files) {
            if ($type == 'image') {
                foreach ($files as $image) {
                    $new_gallery['images'][] = url('public/images/vendor_files/'.$image);
                }
            } 
            if ($type == 'youtube_video') {
                foreach ($files as $youtube_video) {
                    $new_gallery['youtube_video'][] = $youtube_video;
                }
            } 
            if ($type == 'video') {
                foreach ($files as $video) {
                    $new_gallery['videos'][] = url('public/videos/vendor_files/'.$video);
                }
            } 
        }
        return $new_gallery;
    }
}
