<?php

namespace App\Transformers;

use League\Fractal\TransformerAbstract;
use App\User;

class UserTransformer extends TransformerAbstract
{

    protected $defaultIncludes = [
        //
    ];
    
    protected $availableIncludes = [
        //
    ];
    
    public function transform(User $user)
    {
        return [
            'id' => (int) $user->id,
            'name' => (string) $user->name,
            'email' => (string) $user->email,
            'isVerified' => (int) $user->verified,
            'isAdmin' => ($user->admin === 'true'),
            'CreationDate' => $user->created_at->diffForHumans(),
            'LastChange' => $user->updated_at->diffForHumans(),
            'DeletionDate' => isset($user->deleted_at) ? $user->deleted_at->diffForHumans() : null,
        ];
    }

    public static function originalAttribute($index) {

        $attributes = [
            'id' => 'id',
            'name' => 'name',
            'email' => 'email',
            'isVerified' => 'verified',
            'isAdmin' => 'admin',
            'CreationDate' => 'created_at',
            'LastChange' => 'updated_at',
            'DeletionDate' => 'deleted_at',
        ];
        return isset($attributes[$index]) ? $attributes[$index] : null;
    }
}
