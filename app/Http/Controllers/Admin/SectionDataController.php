<?php

namespace App\Http\Controllers\Admin;

use App\SectionData;
use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

class SectionDataController extends Controller
{

    public function getAll()
    {
        $sectionData = SectionData::all();

        return view("admin.sections_data.edit",compact('sectionData'));
    }


    public function store(Request $request)
    {
        dd($request->all());
    }

    
}
