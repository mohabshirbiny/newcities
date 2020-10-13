<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\SectionData;
use App\VendorCategory;

class VendorCategoryController extends Controller
{
    public function getAll()
    {
        $parents = VendorCategory::with("vendor_category_parent",'vendor_category_children')
                                ->where('parent_id',null)
                                ->withCount('vendor_category_children')
                                ->get();

        $section = SectionData::where('model','Vendor')->first();
        
        $data = [
            "parents" => $parents,
            "gallery" => ($section)?$section->section_gallery : (object)[],
        ];

        return APIResponseController::respond(1, "vendors categories", $data, 200);

        $records = VendorCategory::all();
        return APIResponseController::respond(1, [], ["vendors" => $records], 200);
    }

    public function getOne($id)
    {
        if(!VendorCategory::find($id)){
            return APIResponseController::respond(0,'no Vendor Category with this id',[],404); 
        }
        
        $details = VendorCategory::with('vendors')
        ->with('vendor_category_children')
        ->withCount('vendors')
        ->withCount('vendor_category_children')
        ->find($id);
        
        return APIResponseController::respond(1, "Vendor Category", ["vendor_category" => $details], 200);
    }
}
