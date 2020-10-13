<?php

namespace App\Http\Controllers\Api;

use App\Developer;
use App\Http\Controllers\Controller;
use App\SectionData;

class DeveloperController extends Controller
{
    public function getAll()
    {
                                
        $developers = Developer::all();

        $section = SectionData::where('model','Developer')->first();
        
        $data = [
            "developers" => $developers,
            "gallery" => ($section)?$section->section_gallery : (object)[],
        ];

        return APIResponseController::respond(1, 'Developers', $data, 200);
    }

    public function getOne($id)
    {
        $details = Developer::with('compounds')->find($id);
        return APIResponseController::respond(1, 'Developer', ["details" => $details], 200);
    }
}
