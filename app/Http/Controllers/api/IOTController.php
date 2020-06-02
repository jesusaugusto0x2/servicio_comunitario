<?php
namespace App\Http\Controllers\api;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use \GuzzleHttp\Client;

class IOTController extends Controller
{
    public function temperature (Request $request) {
        $client = new Client(['base_uri' => 'http://[2001:660:5307:3116::a482]']);

        $response = $client->request('GET', "temperature");
        $data = $response->getBody()->getContents();

        return response()->json([
            'temperature' => $data,
        ]);
    }

    public function humidity (Request $request) {
        $client = new Client(['base_uri' => 'http://[2001:660:5307:3116::a482]']);

        $response = $client->request('GET', "humidity");
        $data = $response->getBody()->getContents();

        return response()->json([
            'humidity' => $data,
        ]);
    }

    public function temperature_threshold (Request $request) {
        $client = new Client(['base_uri' => 'http://[2001:660:5307:3116::a482]']);

        $response = $client->request('GET', "temp_thr");
        $data = $response->getBody()->getContents();

        return response()->json([
            'temperature_threshold' => $data,
        ]);
    }

    public function humidity_threshold (Request $request) {
        $client = new Client(['base_uri' => 'http://[2001:660:5307:3116::a482]']);

        $response = $client->request('GET', "humi_thr");
        $data = $response->getBody()->getContents();

        return response()->json([
            'humidity_threshold' => $data,
        ]);
    }
}