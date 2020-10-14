<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\DB;

class Property extends Model
{
    protected $fillable = [
        "name", "city_id", "compound_id", "developer_id", "property_type_id", "attachments", "cover", "gallery", 'floor_plans', "about", "use_facilities",
    ];

    protected $appends = [
        "name_en",
        'name_ar',
        "about_en",
        'about_ar',
        'cover_path',
        'property_gallery',
        "attachments_paths",
        'floor_plans_paths',
        "items",
        "facilities"
    ];

    public function getLogoPathAttribute()
    {
        $imageUrl = url('images/property_files/' . $this->logo);
        $imageUrl = url('public/images/property_files/' . $this->logo);
        return $imageUrl;
    }

    public function getCoverPathAttribute()
    {
        $imageUrl = url('images/property_files/' . $this->cover);
        $imageUrl = url('public/images/property_files/' . $this->cover);
        return $imageUrl;
    }

    public function getPropertyGalleryAttribute()
    {
        $gallery = json_decode($this->gallery, true);
        if (!$gallery) {
            return (object) [];
        }

        foreach ($gallery as $type => $files) {
            if ($type == 'image') {
                foreach ($files as $image) {
                    $new_gallery['images'][] = url('public/images/property_files/' . $image);
                }
            }
            if ($type == 'youtube_video') {
                foreach ($files as $youtube_video) {
                    $new_gallery['youtube_video'][] = $youtube_video;
                }
            }
            if ($type == 'video') {
                foreach ($files as $video) {
                    $new_gallery['videos'][] = url('public/videos/property_files/' . $video);
                }
            }
        }
        return $new_gallery;
    }

    public function getFloorPlansPathsAttribute()
    {
        $floor_plans = json_decode($this->floor_plans, true);
        if (!$floor_plans) {
            return (object) [];
        }

        foreach ($floor_plans as $type => $files) {
            if ($type == 'image') {
                foreach ($files as $image) {
                    $new_floor_plans['images'][] = url('public/images/property_files/' . $image);
                }
            }
            if ($type == 'youtube_video') {
                foreach ($files as $youtube_video) {
                    $new_floor_plans['youtube_video'][] = $youtube_video;
                }
            }
            if ($type == 'video') {
                foreach ($files as $video) {
                    $new_floor_plans['videos'][] = url('public/videos/property_files/' . $video);
                }
            }
        }
        return $new_floor_plans;
    }

    public function getAttachmentsPathsAttribute()
    {
        $attachments = json_decode($this->attachments, true);
        if (!$attachments) {
            return (object) [];
        }

        foreach ($attachments as $files) {
            foreach ($files as $video) {
                $new_attachments['attachments'][] = url('public/files/property_files/' . $video);
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

    public function compound()
    {
        return $this->belongsTo(Compound::class);
    }

    public function developer()
    {
        return $this->belongsTo(Developer::class);
    }

    public function getItemsAttribute()
    {
        $items_count = DB::table('property_item')->where("property_id", $this->id)->pluck("count_of_items", "property_item_id")->toArray();
        $items_ids = array_keys($items_count);
        $property_items = PropertyItem::whereIn("id", $items_ids)->get();
        $property_items->map(function ($record) use ($items_count) {
            $record->count = $items_count[$record->id];
        });
        return $property_items;
    }

    public function getFacilitiesAttribute()
    {
        $facility_ids = DB::table('property_facilities')->where("property_id", $this->id)->pluck("facility_id")->toArray();
        $property_facilities = Facility::whereIn("id", $facility_ids)->get();        
        return $property_facilities;
    }
}
