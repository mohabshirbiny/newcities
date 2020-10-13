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
        $parents = ServiceCategory::with("service_category_parent",'service_category_children')
                                ->where('parent_id',null)
                                ->withCount('service_category_children')
                                ->get();

        $section = SectionData::where('model','Service')->first();
        
        $data = [
            "parents" => $parents,
            "gallery" => ($section)?$section->section_gallery : (object)[],
        ];

        return APIResponseController::respond(1, "services categories", $data, 200);
        
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
        if(!ServiceCategory::find($id)){
            return APIResponseController::respond(0,'no Service Category with this id',[],404); 
        }
        
        $details = ServiceCategory::with('services')
        ->with('service_category_children')
        ->withCount('services')
        ->withCount('service_category_children')
        ->find($id);
        
        return APIResponseController::respond(1, "Service Category", ["service_category" => $details], 200);

    }
}
