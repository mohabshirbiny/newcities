<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Article extends Model
{
    protected $fillable = ["article_category_id", "title_en", "title_ar", "image", "brief_en", "brief_ar", "city_id", "body_en", "body_ar", "author_id", "vendor_id", "compound_id"];

    public function article_category()
    {
        return $this->belongsTo(ArticleCategory::class);
    }
}
