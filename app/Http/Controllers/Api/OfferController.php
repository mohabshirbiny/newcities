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
        return api_response(1, "Articles retreived successfully.", $records);
    }

    public function getOne($id)
    {
        $details = Offer::with("offer_category")->find($id);
        return api_response(1, "Article retreived successfully.", $details);
    }
}
