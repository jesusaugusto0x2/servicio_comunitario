<?php
namespace App\Http\Controllers\api;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use GuzzleHttp\Client;

class IOTController extends Controller
{
    public function temperature (Request $request) {
        $response = $client->request('GET', "temperature");
        $data = json_decode($response->getBody());
        dd($data);
        return response()->json([
            'temperature' => 10,
        ]);
    }
}