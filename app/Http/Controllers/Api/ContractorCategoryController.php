<?php

namespace App\Http\Controllers\Api;

use App\ContractorCategory;
use App\Http\Controllers\Controller;

class ContractorCategoryController extends Controller
{
    public function getAll()
    {
        $records = ContractorCategory::get();
        return APIResponseController::respond(1, [], ["contractor_categories" => $records], 200);
    }

    public function getOne($id)
    {
        $details = ContractorCategory::find($id);
        return APIResponseController::respond(1, [], ["details" => $details], 200);
    }
}
