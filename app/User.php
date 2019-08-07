<?php

namespace App;

use Illuminate\Notifications\Notifiable;
use Illuminate\Contracts\Auth\MustVerifyEmail;
use Illuminate\Foundation\Auth\User as Authenticatable;

use Illuminate\Database\Eloquent\SoftDeletes;

class User extends Authenticatable
{
    use Notifiable;

    use SoftDeletes;


    const VERIFIED_USER = 1;
    const UNVERIFIED_USER = 0;

    const ADMIN_USER = 'true';
    const REGULAR_USER = 'false';

    protected $table = 'users';
    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'name',
        'email',
        'password',
        'verified',
        'verification_token',
        'admin',
    ];

    protected $dates = ['deleted_at'];

    /**
     * The attributes that should be hidden for arrays.
     *
     * @var array
     */
    protected $hidden = [
        'password',
        'remember_token',
        'verification_token'
    ];

    public function isAdmin () {
        return $this->admin == User::ADMIN_USER;
    }

    public function isVerified() {
        return $this->verfied == User::VERIFIED_USER;
    }

    public static function generateVerficationCode() {
        return str_random(50);
    }



    // Mutators

    public function setNameAttribute($name) {
        $this->attributes['name'] = strtolower($name);
    }
    
    public function setEmailAttribute($email) {
        $this->attributes['email'] = strtolower($email);
    }
    
    // Accessors
    
    public function getNameAttribute($name) {
        return ucwords($name);
    }
    
    public function getEmailAttribute($email) {
        return ucwords($email);
    }




    protected $casts = [
        'email_verified_at' => 'datetime',
    ];
}
