<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\SectionData;
use App\ServiceCategory;
use Illuminate\Http\Request;

class ServiceCategoryController extends Controller
{
    public function getAll()
    {
        $records = ServiceCategory::withCount("services")->get();
        $section = SectionData::where('model','Service')->first();
        
        $data = [
            "services" => $records,
            "gallery" => ($section)?$section->section_gallery : (object)[],
        ];

        return APIResponseController::respond(1, "Services categories", $data, 200);
    }

    public function getOne($id)
    {
        $details = ServiceCategory::with("services")->find($id);
        return APIResponseController::respond(1, "Services categories", ["details" => $details], 200);
    }
}
