<?php

namespace App\Http\Controllers\Api;

use App\City;
use App\Tender;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\TenderCategory;
use App\Vendor;

class TenderController extends Controller
{
    public function getAll()
    {
        $tender_category_id = request()->tender_category_id;

        $tenders = Tender::query()->with("tender_category")
                        ->Where('tender_category_id','LIKE',$tender_category_id)
                        ->get();

        $tendersCatigories = TenderCategory::query()->select(['id','name'])->get();
        
        $data = [
            "tenders" => $tenders,
            "tenders_categories" => $tendersCatigories,
        ];

        return APIResponseController::respond(1,'tenders retreived successfully',$data,200); 
    }

    public function getOne($id)
    {
        if(!Tender::find($id)){
            return APIResponseController::respond(0,'no Tender with this id',[],404); 
        }

        $tender = Tender::with("tender_category")->find($id);
        $data = [
            "tender" => $tender,
            "related_tenders" => Tender::Where('id','!=',$id)->Where('tender_category_id','=',$tender->tender_category_id)->get(),
        ];

        return APIResponseController::respond(1,"tender retreived successfully.",  $data,200); 
    }
}
