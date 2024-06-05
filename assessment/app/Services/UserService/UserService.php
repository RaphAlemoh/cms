<?php

namespace App\Services\UserService;

use App\Models\User;
use App\Traits\ApiResponser;
use Carbon\Carbon;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Validator;

class UserService
{
    use ApiResponser;

    public function validateSignUpAttributes($request)
    {
        $response  = true;

        $validator = Validator::make($request->all(), [
            'name' => 'required|string|min:2',
            'email' => 'required|string|email|unique:users',
            'mobile' => 'required|string|unique:users',
            'address' => 'required|string|min:5',
            'country_id' => 'required|exists:countries,id',
            'image' => 'required|image|mimes:jpeg,png,jpg,gif,svg|max:2048',
            'password' => 'required|min:8|confirmed'
        ]);

        if ($validator->fails()) {
            return $response = $validator->errors();
        }

        return $response;
    }

    public function createUser($request)
    {

        $user = User::create([
            'name' => $request->name,
            'email' => $request->email,
            'mobile' => $request->mobile,
            'address' => $request->address,
            'country_id' => $request->country_id,
            'password' => Hash::make($request->password),
        ]);

        return $user;
    }
}
