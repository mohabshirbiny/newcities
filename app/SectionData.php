<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class SectionData extends Model
{
    protected $fillables = [
        'title',
        'icon',
        'gallery',
    ];

    protected $appends = [
        "title_en" ,
        'title_ar',
    ];

    public function getTitleEnAttribute()
    {
        return unserialize($this->title)['en'];
    }

    public function getTitleArAttribute()
    {
        return unserialize($this->title)['ar'];
    }
}
