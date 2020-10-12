<?php

namespace App\Http\Controllers\Api;

use App\Contractor;
use App\ContractorCategory;
use App\Http\Controllers\Controller;
use App\SectionData;

class ContractorController extends Controller
{
    public function getAll()
    {

        $contractor_category_id = request()->contractor_category_id;

        $contractors = Contractor::query()->with("category")
                        ->Where('contractor_category_id','LIKE',$contractor_category_id)
                        ->get();
                        
        $contractors = ContractorCategory::all();

        $section = SectionData::where('model','Contractor')->first();
        
        $data = [
            "contractors" => $contractors,
            "contractor_categories" => $contractors,
            "gallery" => ($section)?$section->section_gallery : (object)[],
        ];

        return APIResponseController::respond(1, '', $data, 200);
    }

    public function getOne($id)
    {
        $details = Contractor::with("category",'compounds')->find($id);
        return APIResponseController::respond(1, '', ["contractor" => $details], 200);
    }
}
