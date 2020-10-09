<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Job extends Model
{
    protected $fillable = [
        "type",
        "post_date",
        "post_title",
        "post_description",
        "job_requirements",
        "location",
        "email",
        "mobile",
        "attachment_url",
        'job_category_id',
        'vendor_id',
    ];

    protected $appends = [
        "title_en" ,
        'title_ar',
        "post_title_en" ,
        'post_title_ar',
        "post_description_en" ,
        'post_description_ar',
        "job_requirements_en" ,
        'job_requirements_ar',
        "location_en" ,
        'location_ar',
    ];

    public function job_category()
    {
        return $this->belongsTo(JobCategory::class, "job_category_id", "id");
    }


    public function vendor()
    {
        return $this->belongsTo(Vendor::class, "vendor_id", "id");
    }

    public function getTitleEnAttribute()
    {
        return $this->vendor->title_en;
    }

    public function getTitleArAttribute()
    {
        return $this->vendor->title_ar;
    }

    public function getPostTitleEnAttribute()
    {
        return unserialize($this->post_title)['en'];
    }

    public function getPostTitleArAttribute()
    {
        return unserialize($this->post_title)['ar'];
    }

    public function getPostDescriptionEnAttribute()
    {
        return unserialize($this->post_description)['en'];
    }

    public function getPostDescriptionArAttribute()
    {
        return unserialize($this->post_description)['ar'];
    }

    public function getJobRequirementsEnAttribute()
    {
        return unserialize($this->job_requirements)['en'];
    }

    public function getJobRequirementsArAttribute()
    {
        return unserialize($this->job_requirements)['ar'];
    }

    public function getLocationEnAttribute()
    {
        return unserialize($this->location)['en'];
    }

    public function getLocationArAttribute()
    {
        return unserialize($this->location)['ar'];
    }
}
