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
    ];

    protected $appends = [
        "title_en" ,
        'title_ar',
        "brief_en" ,
        'brief_ar',
        "body_en" ,
        'body_ar',
        'image_path'
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
}
