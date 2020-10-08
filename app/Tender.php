<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Tender extends Model
{

    protected $fillable = [
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

    protected $appends = ["title_en" , 'title_ar'];

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
}
