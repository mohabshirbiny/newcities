<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class OfferCategory extends Model
{
    protected $fillable = ["name", "icon"];

    protected $appends = ["name_en" , 'name_ar'];
    
    protected $hidden  = ["name"];

    public function offers()
    {
        return $this->hasMany(Offer::class, "offer_category_id", "id");
    }
    
    public function getNameEnAttribute()
    {
        return unserialize($this->name)['en'];
    }

    public function getNameArAttribute()
    {
        return unserialize($this->name)['ar'];
    }
}
