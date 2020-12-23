<?php

namespace App\Http\Controllers\API;

use App\Http\Controllers\API\BaseController;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Facades\Auth;
use App\Mitra;
use App\Notifications\MitraEmailVerification;
use Illuminate\Support\Facades\Hash;

class MitraAuthController extends BaseController
{
    public function login(Request $request)
    {
        $credentials = [
            'email' => $request->email,
            'password' => $request->password,
        ];
        
        // FIND A CUSTOMER
        $mitra = Mitra::where('email', $request->email)->first();
        
        // CHECK PASSWORD
        if (Hash::check($request->password, $mitra->password)){
            
            // IF EMAIL NOT VERIFIED THEN RETURN ERROR
            if (!$mitra->hasVerifiedEmail()) {
                return $this->sendError('Email not verified', $credentials, 422);
            }
            // ELSE DO LOGIN
            Auth::login($mitra);
        } else {
            return $this->sendError('Unauthorized', $credentials, 401);
        }

        $mitra = Mitra::find(Auth::user()->id);

        // ELSE THEN RETURN USER WITH TOKEN
        $success['token'] =  $mitra->createToken('ibundailife')->accessToken;
        $success['name'] =  $mitra->name;
        $success['email'] = $mitra->email;

        return $this->sendResponse('Mitra logged in successfully.', $success);
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
            return $this->sendError('Data not valid', $validator->errors(), 401);
        }

        // IF VALID THEN CREATE A USER
        $mitra = Mitra::create([
            'name' => $request->name,
            'email' => $request->email,
            'password' => bcrypt($request->password)
        ]);

        // SEND EMAIL VERIFICATION
        $mitra->notify(new MitraEmailVerification($mitra->id));

        return $this->sendResponse('Mitra created successfully. Please verify email.', $mitra,  201);
    }

    public function verify(Request $request)
    {
        $mitra = Mitra::find($request->id);

        // UPDATE EMAIL VERIFIED AT
        if ($mitra->hasVerifiedEmail()) {
            return response()->json("Email already verified!");
        }

        $mitra->markEmailAsVerified();
        
        return response()->json("Email verified successfully! Please login.");
    }

    public function details()
    {
        $result = Mitra::find(Auth::user()->id);

        return $this->sendResponse('Mitra details', $result);
    }

    public function logout()
    {
        // REVOKE TOKEN FOR SPESIFIC USER
        $token = Auth::user()->token();
        $token->revoke();

        return $this->sendResponse('User logged out succesfully', null);
    }
}
