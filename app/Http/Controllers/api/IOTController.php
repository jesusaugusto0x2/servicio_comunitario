<?php
namespace App\Http\Controllers\api;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use \GuzzleHttp\Client;

class IOTController extends Controller
{
    public function temperature (Request $request) {
        $client = new Client(['base_uri' => 'https://jsonplaceholder.typicode.com']);

        $response = $client->request('GET', "todos/1");

        dd($response);
        $data = json_decode($response->getBody());
        dd($data);
        return response()->json([
            'temperature' => 10,
        ]);
    }
}