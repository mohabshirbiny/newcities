<?php

namespace App\Http\Controllers\Api;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\SectionData;

class SectionDataController extends Controller
{
    public function getAll()
    {
        
        $sections = SectionData::all();
        
        $section = SectionData::where('model','home')->first();
        
        $data = [
            "sections" => $sections,
            "gallery" => ($section)?$section->section_gallery : [],
        ];
        return APIResponseController::respond(1,'Sections Data retreived successfully',$data,200); 
        }
}
