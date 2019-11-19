<?php

namespace App;

use Illuminate\Notifications\Notifiable;
use Illuminate\Contracts\Auth\MustVerifyEmail;
use Illuminate\Foundation\Auth\User as Authenticatable;

use Illuminate\Database\Eloquent\SoftDeletes;

class User extends Authenticatable implements MustVerifyEmail
{
    use Notifiable;
    use SoftDeletes;

    const VERIFIED_USER = 1;
    const UNVERIFIED_USER = 0;

    const ADMIN_USER = 'true';
    const REGULAR_USER = 'false';

    protected $table = 'users';

    protected $fillable = [
        'name',
        'email',
        'password',
        'admin',
    ];

    protected $dates = ['deleted_at'];

    protected $hidden = [
        'password',
        'remember_token',
        'verification_token',
    ];

    public function isAdmin () {
        return $this->admin == User::ADMIN_USER;
    }

    public function isVerified() {
        return $this->email_verified_at == User::VERIFIED_USER;
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
