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
        return APIResponseController::respond(1, "Categories retreived successfully.", ['offer_category' => $records],200); 
    }

    public function getOne($id)
    {
        if(!OfferCategory::find($id)){
            return APIResponseController::respond(0,'no offer category with this id',[],404); 
        }

        $details = OfferCategory::with("offers")->find($id);
        return APIResponseController::respond(1, "Categories retreived successfully.",["data" => $details],200); 
    }
}
