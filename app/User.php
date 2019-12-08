<?php

namespace App;

use Illuminate\Notifications\Notifiable;
use Illuminate\Contracts\Auth\MustVerifyEmail;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Support\Str;
use Illuminate\Database\Eloquent\SoftDeletes;

use App\Transformers\UserTransformer;

class User extends Authenticatable
{
    use Notifiable;
    use SoftDeletes;

    const VERIFIED_USER = 1;
    const UNVERIFIED_USER = 0;

    const ADMIN_USER = 'true';
    const REGULAR_USER = 'false';
    public $transformer = UserTransformer::class;
    protected $table = 'users';

    protected $fillable = [
        'name',
        'email',
        'password',
        'admin',
        'verification_token',
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
        return $this->verified == User::VERIFIED_USER;
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

    public static function generateVerificationCode() {
        return Str::random(40);
    }
}
