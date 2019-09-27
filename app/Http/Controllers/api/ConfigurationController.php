<?php

namespace App\Http\Controllers\api;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;

use App\Bank;
use App\PaymentMethod;

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
}
