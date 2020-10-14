<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Compound extends Model
{
    protected $fillable = ["city_id", "name", "logo",
        "cover", "gallery", 'attachments', "location_url", "about", "contact_details", "social_media"];

    protected $appends = [
        "name_en",
        'name_ar',
        "about_en",
        'about_ar',
        'logo_path',
        'cover_path',
        'social_links',
        'compound_gallery',
        "attachments_paths",
    ];

    public function getLogoPathAttribute()
    {
        $imageUrl = url('images/compound_files/' . $this->logo);
        $imageUrl = url('public/images/compound_files/' . $this->logo);
        return $imageUrl;
    }

    public function developers()
    {
        return $this->belongsToMany(Developer::class,'compound_developer','compound_id','developer_id');
    }

    public function contractors()
    {
        return $this->belongsToMany(Contractor::class,'compound_contractor','compound_id','contractor_id');
    }

    public function getCoverPathAttribute()
    {
        $imageUrl = url('images/compound_files/' . $this->cover);
        $imageUrl = url('public/images/compound_files/' . $this->cover);
        return $imageUrl;
    }

    public function getCompoundGalleryAttribute()
    {
        $gallery = json_decode($this->gallery, true);
        if (!$gallery) {
            return (object) [];
        }

        foreach ($gallery as $type => $files) {
            if ($type == 'image') {
                foreach ($files as $image) {
                    $new_gallery['images'][] = url('public/images/compound_files/' . $image);
                }
            }
            if ($type == 'youtube_video') {
                foreach ($files as $youtube_video) {
                    $new_gallery['youtube_video'][] = $youtube_video;
                }
            }
            if ($type == 'video') {
                foreach ($files as $video) {
                    $new_gallery['videos'][] = url('public/videos/compound_files/' . $video);
                }
            }
        }
        return $new_gallery;
    }

    public function getAttachmentsPathsAttribute()
    {
        $attachments = json_decode($this->attachments, true);
        if (!$attachments) {
            return (object) [];
        }

        foreach ($attachments as $files) {
            foreach ($files as $video) {
                $new_attachments['attachments'][] = url('public/files/compound_files/' . $video);
            }
        }
        return $new_attachments;
    }

    public function getNameEnAttribute()
    {
        return json_decode($this->name, true)['en'];
    }

    public function getNameArAttribute()
    {
        return json_decode($this->name, true)['ar'];
    }

    public function getAboutEnAttribute()
    {
        return json_decode($this->about, true)['en'];
    }

    public function getAboutArAttribute()
    {
        return json_decode($this->about, true)['ar'];
    }

    public function getSocialLinksAttribute()
    {
        return json_decode($this->social_media, true);
    }

    public function getContactDetailsAttribute($value)
    {
        return json_decode($value, true);
    }
}
