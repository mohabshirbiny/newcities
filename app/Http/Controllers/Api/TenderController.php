<?php

namespace App\Http\Controllers\Api;

use App\Tender;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;

class TenderController extends Controller
{
    public function getAll()
    {
        $records = Tender::with("tender_category")->get();
        return APIResponseController::respond(1,"tenders retreived successfully.", ['tenders' => $records],200); 
    }

    public function getOne($id)
    {
        if(!Tender::find($id)){
            return APIResponseController::respond(0,'no Tender with this id',[],404); 
        }

        $details = Tender::with("tender_category")->find($id);
        return APIResponseController::respond(1,"tender retreived successfully.", ['tender' => $details],200); 
    }
}
