<?php

namespace App\Http\Controllers\User;

use Illuminate\Http\Request;
use App\Http\Controllers\ApiController;

use App\User;

class userController extends ApiController
{

    public function index()
    {
        $users = User::all();
        return $this->showAll($users);
    }
    
    public function store(Request $request)
    {
        // set the validation rules
        $rules = [
            'name'       => 'required|min:6|max:20',
            'email'      => 'required|email|unique:users',
            'password'   => 'required|min:6|confirmed',
        ];
            
        // validate the user data
        $this->validate($request, $rules);
        $data = $request->all();

        $data['password'] = bcrypt($request->password);
        $data['verified'] = User::UNVERIFIED_USER;
        $data['verification_token'] = User::generateVerficationCode();
        $data['admin'] = User::REGULAR_USER;

        $user = User::create($data);
        return $this->showOne($user, 201);
    }

    public function show(User $user)
    {
        return $this->showOne($user);
    }

    public function update(Request $request, User $user)
    {
        $rules = [
            'email'     => 'email|unique:users,email,' . $user->id,
            'password'  => 'min:6|confirmed',
            'admin'     => 'in:' . User::REGULAR_USER . ',' . User::ADMIN_USER,    
        ];

        if($request->has('name')) {
            $user->name = $request->name;
        }

        if($request->has('email') && $request->email != $user->email) {
            $user->verified = User::REGULAR_USER;
            $user->verification_token = User::generateVerficationCode();
            $user->email = $request->email;
        }

        if($request->has('password')) {
            $user->password = bcrypt($request->password);
        }

        if($request->has('admin')) {

            if(! $user->isVerified()) {
                return $this->errorResponse('Only Admin Users can modify Admin Area', 'code', 409);
            }
            $user->admin = $request->admin;
        }
        
        if(! $user->isDirty()) {
            return $this->errorResponse('Only Admin Users can modify Admin Area', 'code', 422);
        }
        $user->save();

        return $this->showOne($user);
    }

    public function destroy(User $user)
    {
        $user->delete();
        return $this->showOne($user);
    }


    public function verify($token) {

        $user = User::where('verification_token', $token)->firstOrFail();
        $user->verified = User::VERIFIED_USER;
        $user->verification_token = null;

        $user->save();

        return $this->showMessage("Email Verified Successfully");
    }
}