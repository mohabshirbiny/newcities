<?php

namespace App\Http\Controllers\Api;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\TenderCategory;

class TenderCategoryController extends Controller
{
    public function getAll()
    {
        $records = TenderCategory::all();
        return APIResponseController::respond(1, ["Categories retreived successfully."], $records,200); 
    }

    public function getOne($id)
    {
        $details = TenderCategory::with("tenders")->find($id);
        return APIResponseController::respond(1,[ "Categories retreived successfully."],["data" => $details],200); 
    }
}
