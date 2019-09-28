<?php

namespace App\Http\Controllers\api;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Storage;

use App\Camp;
use App\CampPhoto;
use App\Http\Controllers\Controller;
use Carbon\Carbon;
use Image;

class CampController extends Controller
{  
    /**
     * Private function to save images related to a camp
     * 
     * @param images refrences an array of base64 strings
     * @param camp is the camp we're saving images into
     */
    private function saveImages ($camp, $images) {
        foreach ($images as $img) {
            $image = Image::make($img)->stream('png', 90);

            $current_time = Carbon::now()->format('Ymdhis');
            $path = '/camp_' . $camp->id . '/' . $current_time . '.png';

            Storage::disk('images')->put($path, $image);

            CampPhoto::create([
                'camp_id'   =>  $camp->id,
                'url'       =>  config('app.url') . 'images' . $path,
            ]);
        }
    }

    /**
     * Get all registered camps in the database
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

            if (isset($request->fotos)) {
                $this->saveImages($camp, $request->fotos);
            }

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
                'camp'      =>  $camp->getData()
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

            if (isset($request->location)) {
                $camp->location = $request->location;
            }

            if (isset($request->cost)) {
                $camp->cost = $request->cost;
            }

            if (isset($request->entries)) {
                $camp->entries = $request->entries;
            }

            if (isset($request->date)) {
                $camp->date = $request->date;
            }

            $camp->save();

            return response()->json([
                'status'    =>  'success',
                'message'   =>  'Camp succesfully updated!',
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
        $current_time = Carbon::now()->format('Ymdhis');
        $ok = Image::make($request->base64img)->stream('png', 90);
        Storage::disk('images')->put($current_time . '.png', $ok);
        //$ok->save($path  . '/' . $current_time . '.png' );
        return config('app.url');
    }
}
