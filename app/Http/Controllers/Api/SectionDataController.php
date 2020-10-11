<?php

namespace App\Http\Controllers\Api;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\SectionData;

class SectionDataController extends Controller
{
    public function getAll()
    {
        
        $sections = SectionData::all()->groupBy('model');

        return APIResponseController::respond(1,'Sections Data retreived successfully',['sections' => $sections],200); 
        }
}
