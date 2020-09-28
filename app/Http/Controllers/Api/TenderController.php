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
        return api_response(1, "Articles retreived successfully.", $records);
    }

    public function getOne($id)
    {
        $details = Tender::with("tender_category")->find($id);
        return api_response(1, "Article retreived successfully.", $details);
    }
}
