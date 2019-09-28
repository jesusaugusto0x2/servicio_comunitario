<?php

namespace App\Http\Controllers\api;

use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Storage;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;

use App\Camp;
use App\CampPhoto;
use App\CampPayment;
use Carbon\Carbon;
use App\User;
use Image;

class CampPaymentController extends Controller
{
    /**
     * Private method to make specific URL to the photo related to payment
     * 
     * @param base64 references the string in base64 format.
     * @return url string to access the img inside public folder.
     */
    private function processImg ($img, $camp_id) {
        $image = Image::make($img)->stream('png', 90);

        $current_time = Carbon::now()->format('Ymdhis');
        $path = '/camp_' . $camp_id . '/reference_' . $current_time . '.png';

        Storage::disk('images')->put($path, $image);

        $url =  config('app.url') . 'images' . $path;

        return $url;
    }

    /**
     * Method to store the payment info related to the camp.
     *  
     * Values inside the request body:
     * {
     *  "reference": "numeric string",
     *  "date": "timestamp",
     *  "payment_method_id": number,
     *  "camp_id": number,
     *  "bank_id": number
     * }
     */
    public function store (Request $request) {
        try {
            $user = Auth::user();

            $validator = Validator::make($request->all(), [
                'reference'         =>  'required|string',
                'date'              =>  'required',
                'camp_id'           =>  'required',
                'bank_id'           =>  'required',
                'payment_method_id' =>  'required',
            ]);

            if ($validator->fails()) {
                return response()->json([
                    'status'    =>  'failed',
                    'message'   =>  'Missing items in the request payload'
                ], 400);
            }

            /**
             * If photo is set on the request, url is the return of private function 'processImg'
             * otherwise, the result will be null
             */
            $photo_url = isset($request->photo) ? $this->processImg($request->photo, $request->camp_id) : null;

            $payment = CampPayment::create([
                'reference'         =>  $request->reference,
                'date'              =>  $request->date,
                'photo'             =>  $photo_url,
                'user_id'           =>  $user->id,
                'camp_id'           =>  $request->camp_id,
                'bank_id'           =>  $request->bank_id,
                'payment_method_id' =>  $request->payment_method_id,
            ]);

            return response()->json([
                'status'    =>  'success',
                'message'   =>  'Payment successfully stored',
                'data'      =>  $payment
            ]);
        } catch (\Exception $e) {
            return response()->json([
                'status'    =>  'failed',
                'message'   =>  $e->getMessage()
            ], 500);
        }
    }

    /**
     * Method to validate a payment, valid only for admins
     */
    public function validatePayment ($payment_id) {
        try {
            Auth::user();

            $payment = CampPayment::find($payment_id);

            if (!$payment) {
                return response()->json([
                    'status'    =>  'failed',
                    'message'   =>  'Payment is not registered in our databases'
                ], 404);
            }

            $payment->validated = 1;
            $payment->save();

            return response()->json([
                'status'    =>  'success',
                'message'   =>  'Payment validated',
                'payment'   =>  $payment
            ]);

        } catch (\Exception $e) {
            return response()->json([
                'status'    =>  'failed',
                'message'   =>  $e->getMessage()
            ], 500);
        }
    }
}
