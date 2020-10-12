<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Event extends Model
{
    protected $fillable = [
        "title_en", "title_ar", "event_category_id", "date_from", "date_to", "time_from", "time_to",'city_id',
        'social_links',"contact_details", "location_url", "events_id", "events_location", "cover", "gallery",
        "event_organizer_id", "event_sponsor_id", "about_en", "about_ar",'city_location'
    ];

    protected $appends = ['cover_path','event_gallery'];

    public function city()
    {
        return $this->belongsTo(City::class);
    }

    public function category()
    {
        return $this->belongsTo(EventCategory::class, "event_category_id", "id");
    }

    public function organizers()
    {
        return $this->belongsToMany(EventOrganizer::class,'event_organizer','organizer_id','event_id');
    }

    public function sponsors()
    {
        return $this->belongsToMany(EventSponsor::class,'event_sponsor','sponsor_id','event_id');
    }

    public function interested_customers()
    {
        return $this->belongsToMany(Customer::class);
    }

    // public function getLogoPathAttribute(){
    //     $imageUrl = url('images/events_files/'.$this->logo);
    //     $imageUrl = url('public/images/events_files/'.$this->logo);
    //     return $imageUrl;
    // }

    public function getCoverPathAttribute(){
        $imageUrl = url('images/events_files/'.$this->cover);
        $imageUrl = url('public/images/event_files/'.$this->cover);
        return $imageUrl;
    }

    public function getContactDetailsAttribute($value){        
        return unserialize($value);
    }

    public function getsocialLinksAttribute($value){        
        return unserialize($value);
    }

    public function getEventGalleryAttribute(){
        $gallery = json_decode($this->gallery,true);
        if(!$gallery) return (object)[];
        foreach ($gallery as $type => $files) {
            if ($type == 'image') {
                foreach ($files as $image) {
                    $new_gallery['images'][] = url('public/images/event_files/'.$image);
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
                    $new_gallery['videos'][$i]['video'] = url('public/videos/event_files/'.$video['video']);
                    $new_gallery['videos'][$i]['thumbnail'] = url('public/videos/event_files/'.$video['thumbnail']);
                    $i++;
                }
            } 
        }
        return $new_gallery;
    }
}
