<?php

namespace App\Http\Controllers\Api;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Offer;

class OfferController extends Controller
{
    public function getAll()
    {
        $records = Offer::with("offer_category")->get();
        return APIResponseController::respond(1,'offers retreived successfully',["offers" => $records],200); 
    }

    public function getOne($id)
    {
        if(!Offer::find($id)){
            return APIResponseController::respond(0,'no offer with this id',[],404); 
        }

        $details = Offer::with("offer_category")->find($id);
        
        return APIResponseController::respond(1,'offer retreived successfully',["offer" => $details],200); 
    }
}
