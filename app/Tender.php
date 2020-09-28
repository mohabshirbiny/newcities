<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Tender extends Model
{

    protected $fillable = [];

    public function tender_category()
    {
        return $this->belongsTo(TenderCategory::class, "tender_category_id", "id");
    }
}
