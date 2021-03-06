<?php

namespace App\Http\Controllers\Api;

use App\ArticleCategory;
use App\Http\Controllers\Controller;

class ArticleCategoryController extends Controller
{
    public function getAll()
    {
        $records = ArticleCategory::with('articles')->get();
        return APIResponseController::respond(1, 'Categories retreived successfully', ["categories" => $records], 200);

    }

    public function getOne($id)
    {
        $details = ArticleCategory::with("articles")->find($id);
        return api_response(1, "Category retreived successfully.", $details);
    }
}
