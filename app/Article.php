<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Article extends Model
{
    protected $fillable = ["article_category_id", "title_en", "title_ar", "image", "brief_en", "brief_ar", "city_id", "body_en", "body_ar", "author_id", "vendor_id", "compound_id",'gallery'];

    protected $appends = [
        'article_gallery',
        'image_path',
    ];

    public function article_category()
    {
        return $this->belongsTo(ArticleCategory::class);
    }

    public function getImagePathAttribute(){
        $imageUrl = url('images/article_files/'.$this->cover);
        $imageUrl = url('public/images/article_files/'.$this->cover);
        return $imageUrl;
    }

    public function getArticleGalleryAttribute(){
        $gallery = json_decode($this->gallery,true);
        if(!$gallery) return (object)[];
        foreach ($gallery as $type => $files) {
            if ($type == 'image') {
                foreach ($files as $image) {
                    $new_gallery['images'][] = url('public/images/article_files/'.$image);
                }
            } 
            if ($type == 'youtube_video') {
                foreach ($files as $youtube_video) {
                    $new_gallery['youtube_video'][] = $youtube_video;
                }
            } 
            if ($type == 'video') {
                // dd($files);
                $i = 0;
                foreach ($files as $video) {
                    $new_gallery['videos'][$i]['video'] = url('public/videos/article_files/'.$video['video']);
                    $new_gallery['videos'][$i]['thumbnail'] = url('public/videos/article_files/'.$video['thumbnail']);
                    $i++;
                }
            } 
        }
        return $new_gallery;
    }
}
