<?php

namespace App\Http\Controllers\Api;

use App\City;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Offer;
use App\OfferCategory;
use App\Vendor;

class OfferController extends Controller
{
    public function getAll()
    {
        $vendor_id = request()->vendor_id ;
        $offer_category_id = request()->offer_category_id;
        $location_id = request()->location_id;
        $locationVendorsIds = Vendor::where('city_id', $location_id)->pluck('id');
        // dd($locationVendorsIds);

        $offers = Offer::query()->with("offer_category",'vendor')
                        // ->orWhereIn('vendor_id',$locationVendorsIds)
                        ->Where('vendor_id','LIKE',$vendor_id)
                        ->Where('offer_category_id','LIKE',$offer_category_id)
                        ->get();

        $offersCatigories = OfferCategory::query()->select(['id','name'])->get();
        $vendors = Vendor::query()->select(['id','title_en','title_ar'])->get();
        $locations = City::query()->select(['id','name_en','name_ar'])->get();
        
        $data = [
            "offers" => $offers,
            "offers_categories" => $offersCatigories,
            "vendors" => $vendors,
            "locations" => $locations,
        ];

        return APIResponseController::respond(1,'offers retreived successfully',$data,200); 
    }

    public function getOne($id)
    {
        if(!Offer::find($id)){
            return APIResponseController::respond(0,'no offer with this id',[],404); 
        }

        $details = Offer::with("offer_category",'vendor')->find($id);
        
        return APIResponseController::respond(1,'offer retreived successfully',["offer" => $details],200); 
    }
}
