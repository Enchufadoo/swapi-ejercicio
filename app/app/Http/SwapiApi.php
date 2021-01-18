<?php


namespace App\Http;


class SwapiApi
{

    public function getVehicle(string $type, int $id)
    {
        $client = new \GuzzleHttp\Client(['verify' => false]);

        return $client->request('GET', "https://swapi.dev/api/{$type}/${id}/", [
            'json' =>[]
        ]);
    }
}
