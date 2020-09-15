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
        $details = Article::with("article_category")->find($id);
        return api_response(1, "Article retreived successfully.", $details);
    }
}
