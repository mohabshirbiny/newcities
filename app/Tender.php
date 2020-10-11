<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Tender extends Model
{

    protected $fillable = [
        "city_id",
        "tender_category_id",
        "title",
        "image",
        "date_from",
        "date_to",
        "brief",
        "body",
        "attachment",
        "book_value",
        "insurance_value",
        "gallery",
    ];

    protected $appends = [
        "title_en" ,
        'title_ar',
        "brief_en" ,
        'brief_ar',
        "body_en" ,
        'body_ar',
        'image_path',
        'tender_gallery'
    ];

    public function tender_category()
    {
        return $this->belongsTo(TenderCategory::class, "tender_category_id", "id");
    }

    public function getTitleEnAttribute()
    {
        return unserialize($this->title)['en'];
    }

    public function getTitleArAttribute()
    {
        return unserialize($this->title)['ar'];
    }

    public function getBriefEnAttribute()
    {
        return unserialize($this->brief)['en'];
    }

    public function getBriefArAttribute()
    {
        return unserialize($this->brief)['ar'];
    }

    public function getBodyEnAttribute()
    {
        return unserialize($this->body)['en'];
    }

    public function getBodyArAttribute()
    {
        return unserialize($this->body)['ar'];
    }

    public function getImagePathAttribute(){
        $imageUrl = url('images/tender_files/'.$this->image);
        $imageUrl = url('public/images/tender_files/'.$this->image);
        return $imageUrl;
    }

    public function getTenderGalleryAttribute(){
        $gallery = json_decode($this->gallery,true);
        if(!$gallery) return [];
        foreach ($gallery as $type => $files) {
            if ($type == 'image') {
                foreach ($files as $image) {
                    $new_gallery['images'][] = url('images/offer_files/'.$image);
                }
            } 
            if ($type == 'youtube_video') {
                foreach ($files as $youtube_video) {
                    $new_gallery['youtube_video'][] = $youtube_video;
                }
            } 
            if ($type == 'video') {
                foreach ($files as $video) {
                    $new_gallery['videos'][] = url('videos/offer_files/'.$video);
                }
            } 
        }
        return $new_gallery;
    }
}
