<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Inertia\Inertia;
use GuzzleHttp\Client;

class BreweriesController extends Controller
{

     public function index(Request $request) {
         return Inertia::render('BreweriesList');
      }

      public function breweriesSearch($brewery) {
        $client = new Client();
        $response = $client->get("https://api.openbrewerydb.org/v1/breweries?by_name={$brewery}");
      
        $breweriesData = json_decode($response->getBody(), true);
        $breweries = array_map(function ($brewery) {
            return [
                'id' => $brewery['id'],
                'name' => $brewery['name'],
                'address' => [
                    'street' => $brewery['street'],
                    'city' => $brewery['city'],
                    'state' => $brewery['state'],
                    'postal_code' => $brewery['postal_code'],
                ],
            ];
        }, $breweriesData);

         return response()->json($breweries);
      }

      public function breweries(Request $request){
        $client = new Client();
        $response = $client->get('https://api.openbrewerydb.org/breweries',  [
            'page' => $request->query('page', 1),
        ]);
        $breweriesData = json_decode($response->getBody(), true);
        $breweries = array_map(function ($brewery) {
            return [
                'id' => $brewery['id'],
                'name' => $brewery['name'],
                'address' => [
                    'street' => $brewery['street'],
                    'city' => $brewery['city'],
                    'state' => $brewery['state'],
                    'postal_code' => $brewery['postal_code'],
                ],
            ];
        }, $breweriesData);

        return response()->json($breweries);

      }
}
