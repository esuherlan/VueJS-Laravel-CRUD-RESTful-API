<?php

namespace App\Http\Controllers\API;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;
use App\Models\User;
use App\Models\OauthToken;

class PassportAuthController extends Controller
{
    public function register(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'name' => 'required|min:4',
            'email' => 'required|email',
            'password' => 'required|alpha_num|min:5'
        ]);

        if($validator->fails()) {
            return response()->json(["validation_errors" => $validator->errors()]);
        }
  
        $user = User::create([
            'name' => $request->name,
            'email' => $request->email,
            'password' => bcrypt($request->password)
        ]);
  
        $token = $user->createToken('token')->accessToken;
        $userToken = OauthToken::create([
            'user_id' => $user->id,
            'access_token' => $token
        ]);

        if(!is_null($user)) {
            return response()->json([
                'status' => [
                    'code' => 200,
                    'response' => 'success',
                    'message' => 'Register new user successfully.'
                ],
                'result' => $user
            ]);
        } else {
            return response()->json([
                'status' => [
                    'code' => 200,
                    'response' => 'failed',
                    'message' => 'Register new user failed. Please try again.'
                ],
                'result' => ''
            ]);
        }
    }
}
