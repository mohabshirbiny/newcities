<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class SectionData extends Model
{
    protected $fillable = [
        'title',
        'icon',
        'gallery',
    ];

    protected $appends = [
        "title_en" ,
        'title_ar',
        'section_gallery',
        'icon_path',
    ];

    public function getTitleEnAttribute()
    {
        return unserialize($this->title)['en'];
    }

    public function getTitleArAttribute()
    {
        return unserialize($this->title)['ar'];
    }

    public function getIconPathAttribute(){
        $imageUrl = url('images/section_files/'.$this->icon);
        $imageUrl = url('public/images/section_files/'.$this->icon);
        return $imageUrl;
    }

    public function getSectionGalleryAttribute(){
        $gallery = json_decode($this->gallery,true);
        if(!$gallery) return (object)[];
        foreach ($gallery as $type => $files) {
            if ($type == 'image') {
                foreach ($files as $image) {
                    $new_gallery['images'][] = url('public/images/section_files/'.$image);
                }
            } 
            if ($type == 'youtube_video') {
                foreach ($files as $youtube_video) {
                    $new_gallery['youtube_video'][] = $youtube_video;
                }
            } 
            if ($type == 'video') {
                foreach ($files as $video) {
                    $new_gallery['videos'][] = url('public/videos/section_files/'.$video);
                }
            } 
        }
        return $new_gallery;
    }
}
