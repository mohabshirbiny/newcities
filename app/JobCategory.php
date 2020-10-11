<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class JobCategory extends Model
{
    protected $fillable = ["name", "icon"];

    protected $appends = ["name_en" , 'name_ar','icon_path'];
    
    protected $hidden  = ["name"];

    public function jobs()
    {
        return $this->hasMany(Job::class, "job_category_id", "id");
    }
    
    public function getNameEnAttribute()
    {
        return unserialize($this->name)['en'];
    }

    public function getNameArAttribute()
    {
        return unserialize($this->name)['ar'];
    }

    public function getIconPathAttribute(){
        $imageUrl = url('images/jobs_categories_files/'.$this->icon);
        $imageUrl = url('public/images/jobs_categories_files/'.$this->icon);
        return $imageUrl;
    }
}
