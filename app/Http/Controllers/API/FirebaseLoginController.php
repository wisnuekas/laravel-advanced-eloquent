<?php

namespace App\Http\Controllers\API;

use App\Http\Controllers\API\BaseController;
use Illuminate\Http\Request;
use Kreait\Firebase\Auth;
use Firebase\Auth\Token\Exception\InvalidToken;
use Kreait\Firebase\Exception\Auth\RevokedIdToken;

use App\Customer;
use App\Mitra;

class FirebaseLoginController extends BaseController
{
    public function __construct(Auth $auth)
    {
        $this->auth = $auth;
    }

    public function loginMitra(Request $request)
    {
        $idTokenString = $request->firebaseToken;

        try {
            $verifiedIdToken = $this->auth->verifyIdToken($idTokenString);
        } catch (\InvalidArgumentException $e) {
            return $this->sendError('The token could not be parsed: '.$e->getMessage(), null, 401);
        } catch (InvalidToken $e) {
            return $this->sendError('The token is invalid: ' .$e->getMessage(), null, 401);
        }

        // Retrieve the UID (User ID) from the verified Firebase credential's token
        $uid = $verifiedIdToken->getClaim('sub');

        // Retrieve the user model linked with the Firebase UID
        $mitra = Mitra::where('firebase_uid',$uid)->first();
        
        // Here you could check if the user model exist and if not create it
        if(!$mitra){
            $mitra = Mitra::create([
                'name' => $verifiedIdToken->getClaim('name'),
                'email' => $verifiedIdToken->getClaim('email'),
                'phone_number' => $verifiedIdToken->getClaim('phoneNumber'),
                'firebase_uid' => $verifiedIdToken->getClaim('sub'),
            ]);
        }

        Auth::login($mitra);

        // Once we got a valid user model
        // Create a Personnal Access Token
        $token = $mitra->createToken('ibundailife')->accessToken;

        $data = [
            'name' => $mitra->name,
            'email' => $mitra->email,
            'phone_number' => $mitra->phone_number,
            'token' => $token
        ];
        
        // Return a JSON object containing the token datas
        return $this->sendResponse('Mitra logged in succesfully', $data);
    }

    public function loginCostumer(Request $request)
    {
        $idTokenString = $request->firebaseToken;

        try {
            $verifiedIdToken = $this->auth->verifyIdToken($idTokenString);
        } catch (\InvalidArgumentException $e) {
            return $this->sendError('The token could not be parsed: '.$e->getMessage(), null, 401);
        } catch (InvalidToken $e) {
            return $this->sendError('The token is invalid: ' .$e->getMessage(), null, 401);
        }

        // Retrieve the UID (User ID) from the verified Firebase credential's token
        $uid = $verifiedIdToken->getClaim('sub');

        // Retrieve the user model linked with the Firebase UID
        $customer = Customer::where('firebase_uid',$uid)->first();
        
        // Here you could check if the user model exist and if not create it
        if(!$customer){
            $customer = Customer::create([
                'name' => $verifiedIdToken->getClaim('name'),
                'email' => $verifiedIdToken->getClaim('email'),
                'phone_number' => $verifiedIdToken->getClaim('phoneNumber'),
                'firebase_uid' => $verifiedIdToken->getClaim('sub'),
            ]);
        }

        Auth::login($customer);

        // Once we got a valid user model
        // Create a Personnal Access Token
        $token = $customer->createToken('ibundailife')->accessToken;

        $data = [
            'name' => $customer->name,
            'email' => $customer->email,
            'phone_number' => $customer->phone_number,
            'token' => $token
        ];
        
        // Return a JSON object containing the token datas
        return $this->sendResponse('Customer logged in succesfully', $data);
    }

    public function logout(Request $request)
    {
        $idTokenString = $request->firebaseToken;
        $uid = $idTokenString->getClaim('sub');

        // Logout Passport
        $token = Auth::user()->token();
        $token->revoke();

        // Logout Firebase
        $this->auth->revokeRefreshTokens($uid);

        try {
            $verifiedIdToken = $this->auth->verifyIdToken($idTokenString, $checkIfRevoked = true);
        } catch (RevokedIdToken $e) {
            return $this->sendError($e->getMessage());
        }

        return $this->sendResponse('User logged out succesfully');
    }

    public function userMitra(Request $request)
    {
        // RETURN AUTH USER
        $result = Mitra::find(Auth::user()->id);

        return $this->sendResponse('Mitra details', $result);
    }

    public function userCustomer(Request $request)
    {
        // RETURN AUTH USER
        $result = Customer::find(Auth::user()->id);

        return $this->sendResponse('Customer details', $result);
    }
}
