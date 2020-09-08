<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Article extends Model
{
    protected $fillable = ["article_category_id", "title_en", "title_ar", "image", "brief_en", "brief_ar", "city_id", "body_en", "body_ar", "author", "vendor", "compound"];
}