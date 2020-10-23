<?php

use App\AppSetting;
use Illuminate\Database\Seeder;

class AppSettingsSeed extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $settings = [
            'contact_us',
            'help',
            'sponsors',
            'about_us',
            'about_us_attachments',
            'social_links',
            'terms',
        ];
        foreach ($settings as $key ) {
            if (!AppSetting::where('key',$key)->first()) {
            
                AppSetting::updateOrCreate([
                    'key'  => $key,
                ]);
            }
        }
    }
}
