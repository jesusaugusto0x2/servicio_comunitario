<?php

namespace App\Http\Controllers\api;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;

use App\Bank;
use App\PaymentMethod;
use App\User;

class ConfigurationController extends Controller
{
    /**
     * Method to retrieve bank list
     */
    public function getBanks () {
        try {
            return response()->json([
                'status'    =>  'success',
                'data'      =>  Bank::all()
            ]);
        } catch (\Exception $e) {
            return response()->json([
                'status'    =>  'failed',
                'message'   =>  $e->getMessage()
            ]);
        }
    }

        /**
     * Method to retrieve payment methods bank list
     */
    public function getPaymentMethods () {
        try {
            return response()->json([
                'status'    =>  'success',
                'data'      =>  PaymentMethod::all()
            ]);
        } catch (\Exception $e) {
            return response()->json([
                'status'    =>  'failed',
                'message'   =>  $e->getMessage()
            ]);
        }
    }

    public function makeAdmin ($user_id) {
        try {
            $user = User::find($user_id);

            if (!$user) {
                return response()->json([
                    'status'    =>  'failed',
                    'message'   =>  'User is not registered in our databases'
                ], 404);
            }

            $user->is_admin = 1;
            $user->save();

            return response()->json([
                'status'    =>  'success',
                'message'   =>  'Admin privileges succesfully granted',
                'user'      =>  $user
            ], 200);
        } catch (\Exception $e) {
            return response()->json([
                'status'    =>  'failed',
                'message'   =>  $e->getMessage()
            ]);
        }
    }

    public function blockAllowUser ($user_id) {
        try {
            $user = User::find($user_id);

            if (!$user) {
                return response()->json([
                    'status'    =>  'failed',
                    'message'   =>  'User is not registered in our databases'
                ], 404);
            }

            $user->is_blocked = !$user->is_blocked;
            $user->save();

            $stat = $user->is_blocked == 1 ? 'blocked' : 'unblocked';

            return response()->json([
                'status'    =>  'success',
                'message'   =>  'User succesfully ' . $stat,
                'user'      =>  $user
            ], 200);
        } catch (\Exception $e) {
            return response()->json([
                'status'    =>  'failed',
                'message'   =>  $e->getMessage()
            ]);
        }
    }
}
