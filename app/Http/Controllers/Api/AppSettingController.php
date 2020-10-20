<?php

namespace App\Http\Controllers\Api;

use App\AppSetting;
use App\SectionData;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;

class AppSettingController extends Controller
{
    public function getAll()
    {
        $appSettings = AppSetting::all()->groupby('key')->toArray();

        $sectionHelp = SectionData::where('model', 'help')->first();
        $sectionAboutUs = SectionData::where('model', 'about_us')->first();

        $appSettingsData = [];

        foreach ($appSettings as $key => $value) {
            $appSettingsData[$key] = unserialize( $value[0]['value'] );
        }
        
        $data = array_merge($appSettings,[
            "help_gallery" => ($sectionHelp) ? $sectionHelp->section_gallery : [],
            "about_us_gallery" => ($sectionAboutUs) ? $sectionAboutUs->section_gallery : [],
        ]);
        
        return APIResponseController::respond(1,'', $data,200); 
    }
}
