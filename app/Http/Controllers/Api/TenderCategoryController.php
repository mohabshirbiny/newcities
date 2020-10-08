<?php

namespace App\Http\Controllers\Api;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\TenderCategory;

class TenderCategoryController extends Controller
{
    public function getAll()
    {
        
        $records = TenderCategory::get();
        
        return APIResponseController::respond(1, "Categories retreived successfully.", ['tender_categories' => $records],200); 
    }

    public function getOne($id)
    {
        if(!TenderCategory::find($id)){
            return APIResponseController::respond(0,'no Tender Category with this id',[],404); 
        }

        $details = TenderCategory::with("tenders")->find($id);
        return APIResponseController::respond(1, "Categories retreived successfully.",["tender_category" => $details],200); 
    }
}
