<?php

namespace App\Http\Controllers;

use GuzzleHttp\Client;
use Illuminate\Http\Request;
use GuzzleHttp\Exception\ClientException;

class VehicleController extends Controller
{
    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct()
    {
        $this->client = new Client([
            'base_uri' => env('NHTSA_BASE_URL', 'https://one.nhtsa.gov/webapi')
        ]);
    }

    public function getVehicles(Request $request, $year = null, $manufacturer = null, $model = null)
    {
        $withRating = $request->get('withRating');
        if ($request->getMethod() == 'POST' && $request->headers->get('Content-Type') == 'application/json') {
            return $this->getDataFromNHTSA(
                $request->get('modelYear'),
                $request->get('manufacturer'),
                $request->get('model'),
                $withRating
            );
        }

        if ($request->getMethod() == 'GET') {
            return $this->getDataFromNHTSA($year, $manufacturer, $model, $withRating);
        }
    }


    public function getDataFromNHTSA($year, $manufacturer, $model, $withRating)
    {
        $url = "webapi/api/SafetyRatings/modelyear/{$year}/make/{$manufacturer}/model/{$model}?format=json";
        try {
            $response  = $this->client->get($url);
        } catch (ClientException $e) {
            // Return empty response when NHTSA server return client error...
            return $this->emptyRecordResponse();
        }

        $data = (array) json_decode($response->getBody());

        if (!$data || $data['Count'] == 0) {
            return $this->emptyRecordResponse();
        }

        $vehicle_results = collect($data['Results']);
        $results = $withRating == "true" ? $this->buildResultWithRating($vehicle_results) : $this->buildResultWithoutRating($vehicle_results);

        return response()->json(['Count' => $data['Count'], 'Results' => $results], 200);
    }

    protected  function getVehicleCrashRating($vehicle_id)
    {
        $url = "/webapi/api/SafetyRatings/VehicleId/{$vehicle_id}?format=json";

        try {

            $response = $this->client->get($url);
        } catch (Exception $e) {
            dd($e);
        }

        $data = (array)json_decode($response->getBody());
        return $data['Results'][0]->OverallRating;
    }

    protected  function buildResultWithRating($results)
    {
        return $results->map(function ($results) {
            return  [
                'Description' => $results->VehicleDescription,
                'VehicleId' => $results->VehicleId,
                "CrashRating" => $this->getVehicleCrashRating($results->VehicleId)
            ];
        });
    }

    protected function buildResultWithoutRating($results)
    {
        return $results->map(function ($results) {
            return  [
                'Description' => $results->VehicleDescription,
                'VehicleId' => $results->VehicleId
            ];
        });
    }
    

    protected function emptyRecordResponse(){
        return response()->json(['Count' => 0, 'Results' => []]);
    }
}
