<?php

namespace App\Http\Controllers\API;

use App\Http\Controllers\Controller;
use App\Http\Controllers\API\BaseController as BaseController;
use Illuminate\Support\Facades\Validator;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

use App\User;

class AuthController extends BaseController
{
    public function login(Request $request)
    {
        $credentials = [
            'email' => $request->email,
            'password' => $request->password
        ];

        // IF AUTH FAILS THEN RETURN ERROR
        if (!Auth::attempt($credentials)) {
            return $this->sendError('Unauthorized', $credentials ,401);
        }

        // ELSE THEN RETURN USER WITH TOKEN
        $user = Auth::user();
        $success['token'] =  User::find($user->id)->createToken('ibundailife')->accessToken;
        $success['name'] =  $user->name;
        $success['email'] = $user->email;

        return $this->sendResponse($success, 'User logged in successfully.');
    }

    public function register(Request $request)
    {
        $validator = Validator::make($request->all(),[
            'name' => 'required|min:3',
            'email' => 'required|email|unique:users',
            'password' => 'required',
            'c_password' => 'required|same:password'
        ]);

        // IF NOT VALID RETURN ERROR
        if ($validator->fails()) {
            return $this->sendError('Data not valid', $validator->errors());
        }

        // IF VALID THEN CREATE A USER
        $data = $request->all();
        $data['password'] = bcrypt($data['password']);
        $user = User::create($data);

        // TODO: CREATE ROLE_USER
        # code...

        // RETURN USER WITH TOKEN
        $success['token'] =  $user->createToken('ibundailife')->accessToken;
        $success['name'] =  $user->name;
        $success['email'] = $user->email;

        return $this->sendResponse($success, 'User register successfully.');

    }

    public function details()
    {
        // RETURN USER
        // return $this->sendResponse(Auth::user(), null);

        return $this->sendResponse(auth(), null);

    }

    public function logout()
    {
        // REVOKE TOKEN FOR SPESIFIC USER
        return $this->sendResponse(null, 'User logged out succesfully');
    }
}
