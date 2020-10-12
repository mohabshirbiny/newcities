<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Service extends Model
{
    protected $fillable = ["service_category_id", "name", "logo",
        "cover", "gallery", "location_url", "about", "contact_details", "social_media"];

    public function service_category()
    {
        return $this->belongsTo(ServiceCategory::class);
    }

    protected $appends = [
        "title_en",
        'title_ar',
        "about_en",
        'about_ar',
        'logo_path',
        'cover_path',
        'service_gallery',
        "email", "website", "mobile", "phone", "whatsapp", "working_hours", "address",
        "facebook", "twitter", "instagram", "youtube",
    ];

    public function getTitleEnAttribute()
    {
        return json_decode($this->name, true)['en'];
    }

    public function getTitleArAttribute()
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

    // Contact details
    public function getEmailAttribute()
    {
        return json_decode($this->contact_details, true)['email'];
    }
    public function getWebsiteAttribute()
    {
        return json_decode($this->contact_details, true)['website'];
    }
    public function getMobileAttribute()
    {
        return json_decode($this->contact_details, true)['mobile'];
    }
    public function getPhoneAttribute()
    {
        return json_decode($this->contact_details, true)['phone'];
    }
    public function getWhatsappAttribute()
    {
        return json_decode($this->contact_details, true)['whatsapp'];
    }
    public function getWorkingHoursAttribute()
    {
        return json_decode($this->contact_details, true)['working_hours'];
    }
    public function getAddressAttribute()
    {
        return json_decode($this->contact_details, true)['address'];
    }

    // Social Media
    public function getFacebookAttribute()
    {
        return json_decode($this->social_media, true)['facebook'];
    }
    public function getTwitterAttribute()
    {
        return json_decode($this->social_media, true)['twitter'];
    }
    public function getInstagramAttribute()
    {
        return json_decode($this->social_media, true)['instagram'];
    }
    public function getYoutubeAttribute()
    {
        return json_decode($this->social_media, true)['youtube'];
    }

    public function getLogoPathAttribute()
    {
        $imageUrl = url('images/service_files/' . $this->logo);
        $imageUrl = url('public/images/service_files/' . $this->logo);
        return $imageUrl;
    }

    public function getCoverPathAttribute()
    {
        $imageUrl = url('images/service_files/' . $this->cover);
        $imageUrl = url('public/images/service_files/' . $this->cover);
        return $imageUrl;
    }

    public function getServiceGalleryAttribute()
    {
        $gallery = json_decode($this->gallery, true);
        if (!$gallery) {
            return [];
        }

        foreach ($gallery as $type => $files) {
            if ($type == 'image') {
                foreach ($files as $image) {
                    $new_gallery['images'][] = url('public/images/service_files/' . $image);
                }
            }
            if ($type == 'youtube_video') {
                foreach ($files as $youtube_video) {
                    $new_gallery['youtube_video'][] = $youtube_video;
                }
            }
            if ($type == 'video') {
                foreach ($files as $video) {
                    $new_gallery['videos'][] = url('public/videos/service_files/' . $video);
                }
            }
        }
        return $new_gallery;
    }

}
