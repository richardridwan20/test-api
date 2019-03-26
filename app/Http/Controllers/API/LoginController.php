<?php

namespace App\Http\Controllers\API;

use Illuminate\Http\Request;
use App\User;
use App\Http\Controllers\API\BaseController as BaseController;
use Illuminate\Support\Facades\Auth;
use Validator;
use Hash;

class LoginController extends BaseController
{
    /**
     * Register a new User.
     *
     * @return \Illuminate\Http\Response
     */
    public function login (Request $request) {

        $user = User::where('email', $request->email)->first();
    
        if ($user) {
    
            if (Hash::check($request->password, $user->password)) {
                $token = $user->createToken('Laravel Password Grant Client')->accessToken;
                $response['token'] = $token;
                return $this->sendResponse($response, 'User Created Successfully.');
            } else {
                $response = "Password mismatch";
                return $this->sendError('Validation Error', $response);
            }
    
        } else {
            $response = 'User does not exist';
            return $this->sendError('Validation Error', $response);
        }
    }
}
