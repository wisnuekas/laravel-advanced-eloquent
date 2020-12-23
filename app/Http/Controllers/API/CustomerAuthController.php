<?php

namespace App\Http\Controllers\API;

use App\Http\Controllers\API\BaseController;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Facades\Auth;
use App\Customer;
use App\Notifications\EmailVerification;
use Illuminate\Support\Facades\Hash;

class CustomerAuthController extends BaseController
{
    public function login(Request $request)
    {
        // $credentials = $request->only('email', 'password');

        $credentials = [
            'email' => $request->email,
            'password' => $request->password,
        ];
        
        // FIND A CUSTOMER
        $customer = Customer::where('email', $request->email)->first();
        
        // CHECK PASSWORD
        if (Hash::check($request->password, $customer->password)){
            
            // IF EMAIL NOT VERIFIED THEN RETURN ERROR
            if (!$customer->hasVerifiedEmail()) {
                return $this->sendError('Email not verified', $credentials, 422);
            }
            // ELSE DO LOGIN
            Auth::login($customer);
        } else {
            return $this->sendError('Unauthorized', $credentials, 401);
        }

        $customer = Customer::find(Auth::user()->id);

        // ELSE THEN RETURN USER WITH TOKEN
        $success['token'] =  $customer->createToken('ibundailife')->accessToken;
        $success['name'] =  $customer->name;
        $success['email'] = $customer->email;

        return $this->sendResponse('User logged in successfully.', $success);
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
        $customer = Customer::create([
            'name' => $request->name,
            'email' => $request->email,
            'password' => bcrypt($request->password)
        ]);

        // SEND EMAIL VERIFICATION
        $customer->notify(new EmailVerification($customer->id));

        return $this->sendResponse('User created successfully. Please verify email.', $customer,  201);
    }

    public function verify(Request $request)
    {
        $customer = Customer::find($request->id);

        // UPDATE EMAIL VERIFIED AT
        if ($customer->hasVerifiedEmail()) {
            return response()->json("Email already verified!");
        }

        $customer->markEmailAsVerified();
        
        // RETURN SUCCESS RESPONSE
        return response()->json("Email verified successfully! Please login.");
    }

    public function details()
    {
        // RETURN AUTH USER
        $result = Customer::find(Auth::user()->id);

        return $this->sendResponse('Customer details', $result);
    }

    public function logout()
    {
        // REVOKE TOKEN FOR SPESIFIC USER
        $token = Auth::user()->token();
        $token->revoke();

        return $this->sendResponse('User logged out succesfully', null);
    }
}
