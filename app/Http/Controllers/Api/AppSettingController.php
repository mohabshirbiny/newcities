<?php

namespace App\Http\Controllers\Api;

use App\AppSetting;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;

class AppSettingController extends Controller
{
    public function getAll()
    {
        $appSettings = AppSetting::all()->groupby('key')->toArray();


        $appSettingsData = [];

        foreach ($appSettings as $key => $value) {
            $appSettingsData[$key] = unserialize( $value[0]['value'] );
        }
        return APIResponseController::respond(1,'', $appSettingsData,200); 
    }
}
