<?php

namespace App\Http\Controllers\Api;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\OfferCategory;

class OfferCategoryController extends Controller
{
    public function getAll()
    {
        $records = OfferCategory::all();
        return APIResponseController::respond(1, ["Categories retreived successfully."], $records,200); 
    }

    public function getOne($id)
    {
        $details = OfferCategory::with("offers")->find($id);
        return APIResponseController::respond(1,[ "Categories retreived successfully."],["data" => $details],200); 
    }
}
