<?php

namespace App\Http\Controllers\Api;

use App\Article;
use App\Http\Controllers\Controller;

class ArticleController extends Controller
{
    public function getAll()
    {
        $records = Article::with("article_category")->get();
        return api_response(1, "Articles retreived successfully.", $records);
    }

    public function getOne($id)
    {
        $data['details'] = Article::with("article_category")->find($id);
        $data['related_articles'] = Article::where("article_category_id", $data['details']->article_category_id)
            ->where("id", "<>", $id)->limit(5)->get();
        return api_response(1, "Article retreived successfully.", $data);
    }
}
