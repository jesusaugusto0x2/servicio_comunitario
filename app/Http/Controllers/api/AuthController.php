<?php

namespace App\Http\Controllers\api;

use App\Http\Controllers\Controller;
use App\User;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Facades\Auth;

use Carbon\Carbon;

class AuthController extends Controller {

    public function signup(Request $request) {
        try {
            $validator = Validator::make($request->all(), [
                'name'  =>  'required|string',
                'email' =>  'required|string|email|unique:users',
                'password'  =>  'required|string'
            ]);
    
            if ($validator->fails()) {
                return response()->json([
                    'status'    =>  'failed',
                    'message'   =>  'Missing items or invalid email'
                ]);
            }

            $user = User::create([
                'name'     => $request->name,
                'email'    => $request->email,
                'password' => bcrypt($request->password),
            ]);
    
            $user->save();
    
            return response()->json([
                'status'    =>  'success',
                'message'   =>  'User created!'
            ], 201);

        } catch (\Exception $e) {
            return response()->json([
                'status'    =>  'failed',
                'error'     =>  $e->getMessage()
            ]);
        }
    }

    public function login(Request $request) {
        try {

            $validator = Validator::make($request->all(), [
                'email'       => 'required|string|email',
                'password'    => 'required|string',
                'remember_me' => 'boolean',
            ]);
    
            if ($validator->fails()) {
                return response()->json([
                    'status'    =>  'failed',
                    'message'   =>  'Missing items or invalid email'
                ]);
            }
    
            $credentials = request(['email', 'password']);
    
            if (!Auth::attempt($credentials)) {
                return response()->json([
                    'status'    =>  'failed',
                    'message'   =>  'User is not authorized'
                ], 401);
            }
    
            $user = $request->user();
            $tokenResult = $user->createToken('Personal Access Token');
            $token = $tokenResult->token;
    
            if ($request->remember_me) {
                $token->expires_at = Carbon::now()->addWeeks(1);
            }
    
            $token->save();
    
            return response()->json([
                'status'        =>  'success',
                'access_token'  =>  $tokenResult->accessToken,
                'token_type'    =>  'Bearer',
                'expires_at'    =>  Carbon::parse($tokenResult->token->expires_at)->toDateTimeString(),
            ], 200);

        } catch (\Exception $e) {
            return response()->json([
                'status'    =>  'failed',
                'error'     =>  $e->getMessage()
            ]);
        }
    }

    public function logout(Request $request) {
        try {
            $request->user()->token()->revoke();
        
            return response()->json([
                'status'    =>  'success',
                'message'   =>    'Successfully logged out'
            ], 200);
            
        } catch (\Exception $e) {
            return response()->json([
                'status'    =>  'failed',
                'error'     =>  $e->getMessage()
            ]); 
        }
    }

    public function user(Request $request)
    {
        try {
            return response()->json($request->user());
        } catch (\Exception $e) {
            return response()->json([
                'status'    =>  'failed',
                'error'     =>  $e->getMessage()
            ]);     
        }
    }
}
