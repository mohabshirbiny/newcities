<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Tymon\JWTAuth\Contracts\JWTSubject;
use Illuminate\Notifications\Notifiable;

class Customer extends Authenticatable implements JWTSubject
{
    protected $fillable = [
        'name',
        'mobile' ,
        'email' ,
        'password',
        'device_id',
        'birthdate',
        'governorate',
        'subscription_status',
        'verification_code',
        'job_title',
        'cv_url',
        'about',
        'location_governorate',
        'location_city',
        'allow_appearing',
    ];

    /**
     * Get the identifier that will be stored in the subject claim of the JWT.
     *
     * @return mixed
     */
    public function getJWTIdentifier()
    {
        return $this->getKey();
    }

    /**
     * Return a key value array, containing any custom claims to be added to the JWT.
     *
     * @return array
     */
    public function getJWTCustomClaims()
    {
        return [];
    }

    public function events()
    {
        return $this->belongsToMany(Event::class);
    }

}
