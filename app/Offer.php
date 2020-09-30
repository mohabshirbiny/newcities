<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Offer extends Model
{
    
    public function offer_category()
    {
        return $this->belongsTo(OfferCategory::class, "offer_category_id", "id");
    }

}
