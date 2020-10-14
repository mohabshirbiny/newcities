<?php

namespace App\Http\Controllers\Api;

use App\Article;
use App\Http\Controllers\Controller;

class ArticleController extends Controller
{
    public function getAll()
    {
        $records = Article::with("article_category")->get();
        return APIResponseController::respond(1, 'Articles retreived successfully', ["articles" => $records], 200);
    }

    public function getOne($id)
    {
        $data['details'] = Article::with("article_category")->find($id);
        $data['related_articles'] = Article::where("article_category_id", $data['details']->article_category_id)
            ->where("id", "<>", $id)->limit(8)->get();
        return APIResponseController::respond(1, 'Article retreived successfully', $data, 200);

        return api_response(1, "Article retreived successfully.", $data);
    }
}
