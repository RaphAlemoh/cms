<?php

namespace App\Http\Controllers;

use App\Models\User;
use App\Services\UserService\UserService;
use App\Traits\ApiResponser;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Validator;

class UserController
{
    use ApiResponser;


    public function login(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'email' => 'required|email',
            'password' => 'required'
        ]);

        if ($validator->fails()) {
            return $this->errorResponse($validator->errors(), 400);
        }

        $user = User::where([
            ['email', '!=', null],
            ['email', '=', $request['email']],
        ])->first();

        if (!$user) {
            return $this->errorResponse('Invalid Credentials!', 400);
        }

        if (!empty($user) && Hash::check($request['password'], $user->password)) {

            $user->save();
            $success['token'] = $user->createToken('assessment-api')->plainTextToken;

            return $this->showOne($success, 200);
        } else {
            return $this->errorResponse('Invalid Credentials', 400);
        }
    }

    public function user(Request $request)
    {

        if ($request->isMethod('post')) {
            return $this->register($request);
        }

        if ($request->isMethod('get')) {
            return $this->getUser($request);
        }
    }

    public function logout(Request $request)
    {
        $request->user()->currentAccessToken()->delete();
        return  $this->showOne("Logged out successfully!!!", 200);
    }

    private function register($request)
    {
        $userService  = new UserService;

        $signUpValidation = $userService->validateSignUpAttributes($request);

        if ($signUpValidation != true) {
            return $this->errorResponse($signUpValidation, 400);
        }

        $email_exist = User::where('email', '=', $request->email)->exists();

        if ($email_exist) {
            return $this->errorResponse("Oops! This email already exist", 400);
        }

        $user = $userService->createUser($request);

        if ($user) {
            return  $this->showOne("Registration was successful!!!", 200);
        }
        return $this->errorResponse("Oops! Registration Faiiled", 400);
    }

    private function getUser()
    {
        $user = auth()->user();
        $user->country = $user->country;
        return $this->showOne($user, 200);
    }
}
