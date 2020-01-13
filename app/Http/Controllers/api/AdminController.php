<?php

namespace App\Http\Controllers\api;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;
use App\Http\Controllers\Controller;

use App\User;

class AdminController extends Controller
{
    /**
     * Retrives all user listing
     */
    public function getUsers () {
        try {
            $users = User::where('is_admin', 0)->paginate(10);

            return response()->json($users, 200);
        } catch (\Exception $e) {
            return response()->json([
                'status'    =>  'failed',
                'error'     =>  $e->getMessage()
            ], 500);
        }
    }

    /**
     * Method to search and see data of an specific user
     *
     * @param $user_id references the db id user to be searched
     */
    public function getSpecUser ($user_id) {
        try {
            $user = User::find($user_id);

            if (!$user) {
                return response()->json([
                    'status'    =>  'failed',
                    'error'     =>  'User not found',
                    'message'   =>  'User does not exists in our databases!'
                ], 404);
            }

            return response()->json([
                'status'    =>  'success',
                'message'   =>  'User found!',
                'user'      =>  $user
            ], 200);
        } catch (\Exception $e) {
            return response()->json([
                'status'    =>  'failed',
                'error'     =>  $e->getMessage()
            ], 500);
        }
    }

    /**
     * Function to change any user passwords when logged as admin
     */
    public function changeUserPass (Request $request, $user_id) {
        try {
            $user = User::find($user_id);

            if (!$user) {
                return response()->json([
                    'status'    =>  'failed',
                    'error'     =>  'User not found',
                    'message'   =>  'User does not exists in our databases!'
                ], 404);
            }

            $validator = Validator::make($request->all(), [
                'password'  =>  'required|confirmed'
            ]);

            if ($validator->fails()) {
                return response()->json([
                    'status'    =>  'failed',
                    'error'     =>  'Password does not match!',
                    'message'   =>  'Passwords are not the same'
                ], 401);
            }

            $user->password = bcrypt($request->password);
            $user->save();

            return response()->json([
                'status'    =>  'success',
                'message'   =>  'Password changed!',
                'user'      =>  $user
            ], 200);

        } catch (\Exception $e) {
            return response()->json([
                'status'    =>  'failed',
                'error'     =>  $e->getMessage()
            ], 500);
        }
    }
}
