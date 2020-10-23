<?php

namespace App\Http\Controllers\Admin;

use App\AppSetting;
use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Yajra\DataTables\Facades\DataTables;

class AppSettingController extends Controller
{
    public function getAll()
    {
        $appSettings = AppSetting::all()->groupby('key')->toArray();
        
        $appSettingsData = [];

        foreach ($appSettings as $key => $value) {
            try {
                $appSettingsData[$key] = (unserialize( $value[0]['value']))? unserialize( $value[0]['value'] ): [];
            } catch (\Throwable $th) {
                throw $key;
            }
            
        }
        
        return view("admin.app_settings.index", compact("appSettingsData"));

    }

    public function store(Request $request)
    {
        $data = $request->all();
        if ($request->has('about_us_attachments')) {
            $request['about_us_attachments'] = explode("\n", str_replace("\r", "", $request->about_us_attachments ));
        }
        // dd($request->all() );
        foreach ($data as $key => $value) {
            // $appSettings = AppSetting::where('key',$key)->first();
            // if ($key == 'help') {
            //     dd($appSettings->value);
            //     $gallery = $$value->gallery;
            //     $value_decoded = [];
            //     if ($gallery) {
            //         $gallery_decoded = json_decode($gallery, true);
            //         $gallery_decoded[$request->file_type][] = $uploaded_gallery;
            //     } else {
            //         $gallery_decoded[$request->file_type][] = $uploaded_gallery;
            //     }
            // }
            AppSetting::where('key',$key)->update([
                'value' => serialize($value)
            ]);
        }

        return redirect(route("settings.index"))->with("success_message", "settings has been updated successfully.");
    }
}
