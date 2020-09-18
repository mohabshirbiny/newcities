<?php

namespace App\Http\Controllers\Api;

use App\ArticleCategory;
use App\Http\Controllers\Controller;

class ArticleCategoryController extends Controller
{
    public function getAll()
    {
        $records = ArticleCategory::all();
        return api_response(1, "Categories retreived successfully.", $records);
    }

    public function getOne($id)
    {
        $details = ArticleCategory::with("articles")->find($id);
        return api_response(1, "Category retreived successfully.", $details);
    }
}
