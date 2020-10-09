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
        $vendor_id = request()->vendor_id ;
        $offer_category_id = request()->offer_category_id;
        $location_id = request()->location_id;
        $locationVendorsIds = Vendor::where('city_id', $location_id)->pluck('id');
        // dd($locationVendorsIds);

        $tenders = Tender::query()->with("offer_category",'vendor')
                        ->orWhereIn('vendor_id',$locationVendorsIds)
                        ->Where('vendor_id','LIKE',$vendor_id)
                        ->Where('offer_category_id','LIKE',$offer_category_id)
                        ->get();

        $tendersCatigories = TenderCategory::query()->select(['id','name'])->get();
        $vendors = Vendor::query()->select(['id','title_en','title_ar'])->get();
        $locations = City::query()->select(['id','name_en','name_ar'])->get();
        
        $data = [
            "tenders" => $tenders,
            "tenders_categories" => $tendersCatigories,
            "vendors" => $vendors,
            "locations" => $locations,
        ];

        return APIResponseController::respond(1,'tenders retreived successfully',$data,200); 
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
