<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class AppSetting extends Model
{
    protected $appends = [
        // "value" ,
        // 'about_ar',
        "contact_details" ,
        'social_links',
    ];

    public function getContactDetailsAttribute($value){        
        return unserialize($value);
    }

    public function getsocialLinksAttribute($value){        
        return unserialize($value);
    }

}
