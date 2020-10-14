<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class ArticleCategory extends Model
{
    protected $fillable = ["title_en", "title_ar", "icon"];

    protected $appends = ["icon_path"];

    public function articles()
    {
        return $this->hasMany(Article::class, "article_category_id", "id");
    }

    public function getIconPathAttribute(){
        $imageUrl = url('public/images/article_categories_files/'.$this->icon);
        return $imageUrl;
    }
}
