<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Contractor extends Model
{
    protected $fillable = ["contractor_category_id", "name", "logo",
        "cover", "gallery", "location_url", "about", "contact_details", "social_media"];

    protected $appends = [
        "name_en" ,
        'name_ar',
        "about_en" ,
        'about_ar',
        'cover_path',
        'logo_path',
        'image_path',
        'contractor_gallery',
        'social_links'
    ];

    public function category()
    {
        return $this->belongsTo(ContractorCategory::class, "contractor_category_id", "id");
    }

    public function compounds()
    {
        return $this->belongsToMany(Compound::class,'compound_contractor','compound_id','contractor_id');
    }

    public function getLogoPathAttribute(){
        $imageUrl = url('images/contractor_files/'.$this->logo);
        $imageUrl = url('public/images/contractor_files/'.$this->logo);
        return $imageUrl;
    }

    public function getCoverPathAttribute(){
        $imageUrl = url('images/contractor_files/'.$this->cover);
        $imageUrl = url('public/images/contractor_files/'.$this->cover);
        return $imageUrl;
    }

    public function getImagePathAttribute(){
        $imageUrl = url('images/contractor_files/'.$this->cover);
        $imageUrl = url('public/images/contractor_files/'.$this->cover);
        return $imageUrl;
    }

    public function getNameEnAttribute()
    {
        return json_decode($this->name)->en;
    }

    public function getNameArAttribute()
    {
        return json_decode($this->name)->ar;
    }

    public function getAboutEnAttribute()
    {
        return json_decode($this->about,true)['en'];
    }

    public function getAboutArAttribute()
    {
        return json_decode($this->about,true)['ar'];
    }
    
    public function getSocialLinksAttribute()
    {
        return json_decode($this->social_media,true);
    }

    public function getContactDetailsAttribute($value){        
        return json_decode($value,true);
    }

    public function getContractorGalleryAttribute(){
        $gallery = json_decode($this->gallery,true);
        if(!$gallery) return (object)[];
        foreach ($gallery as $type => $files) {
            if ($type == 'image') {
                foreach ($files as $image) {
                    $new_gallery['images'][] = url('images/contractor_files/'.$image);
                }
            } 
            if ($type == 'youtube_video') {
                foreach ($files as $youtube_video) {
                    $new_gallery['youtube_video'][] = $youtube_video;
                }
            } 
            if ($type == 'video') {
                foreach ($files as $video) {
                    $new_gallery['videos'][] = url('videos/contractor_files/'.$video);
                }
            } 
        }
        return $new_gallery;
    }
}
