<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Offer extends Model
{
    protected $fillable = [
        "title",
        "description",
        "image",
        "price_before",
        "price_after",
        "order_tel_number",
        "expiration_date",
        "discount_percentage",
        "url",
        "vendor_id",
        "product_id",
        'offer_category_id',
    ];

    protected $appends = ["title_en" , 'title_ar'];

    public function offer_category()
    {
        return $this->belongsTo(OfferCategory::class, "offer_category_id", "id");
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
