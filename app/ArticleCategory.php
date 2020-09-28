<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class ArticleCategory extends Model
{
    protected $fillable = ["title_en", "title_ar", "icon"];

    public function articles()
    {
        return $this->hasMany(Article::class, "article_category_id", "id");
    }
}
