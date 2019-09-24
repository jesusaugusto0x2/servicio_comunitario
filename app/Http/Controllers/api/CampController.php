<?php

namespace App\Http\Controllers\api;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Facades\Auth;

use App\Camp;
use App\Http\Controllers\Controller;
use Image\Image;

class CampController extends Controller
{
    /**
     * Get all registered camps in the 
     */
    public function index () {
        try {
            $camps = Camp::paginate(10);

            return response()->json([
                'status'    =>  'success',
                'message'   =>  'Retrieving list of all camps registered',
                'camp'      =>  $camps
            ]);

        } catch (\Exception $e) {
            return response()->json([
                'status'    =>  'failed',
                'message'   =>  $e->getMessage()
            ], 500);
        }
    }

    /**
     * Store a new camp in database
     */
    public function store (Request $request) {
        try {

            $validator = Validator::make($request->all(), [
                'location'  =>  'required|string',
                'entries'   =>  'required|numeric',
                'cost'      =>  'required',
                'date'      =>  'required'
            ]);
    
            if ($validator->fails()) {
                return response()->json([
                    'status'    =>  'failed',
                    'message'   =>  'Missing items in the request payload'
                ], 400);
            }

            $camp = Camp::create([
                'location'  =>  $request->location,
                'entries'   =>  $request->entries,
                'cost'      =>  $request->cost,
                'date'      =>  $request->date
            ]);

            return response()->json([
                'status'    =>  'success',
                'message'   =>  'Camp succesfully created',
                'camp'      =>  $camp
            ], 200);

        } catch (\Exception $e) {
            return response()->json([
                'status'    =>  'failed',
                'message'   =>  $e->getMessage()
            ], 500);
        }
    }

    /**
     * Retrieve a single camp for its information.
     */
    public function get ($id) {
        try {
            $camp = Camp::find($id);

            if (!$camp) {
                return response()->json([
                    'status'    =>  'failed',
                    'message'   =>  'Camp is not registered in our databases'
                ], 404);
            }

            return response()->json([
                'status'    =>  'success',
                'message'   =>  'Camp found!',
                'camp'      =>  $camp
            ]);

        } catch (\Exception $e) {
            return response()->json([
                'status'    =>  'failed',
                'message'   =>  $e->getMessage()
            ], 500);
        }
    }    

    /**
     * Edit an existent instance of Camp
     */
    public function edit (Request $request, $id) {
        try {
            $camp = Camp::find($id);

            if (!$camp) {
                return response()->json([
                    'status'    =>  'failed',
                    'message'   =>  'Camp is not registered in our databases'
                ], 404);
            }

            $camp->update([

            ]);

            return response()->json([
                'status'    =>  'success',
                'message'   =>  'Camp succesfully created',
                'camp'      =>  $camp
            ]);

        } catch (\Exception $e) {
            return response()->json([
                'status'    =>  'failed',
                'message'   =>  $e->getMessage()
            ], 500);
        }
    }

    public function testphoto (Request $request) {
        $ok = Image::make($request->base64img);

        return 'Ok';
    }
}
