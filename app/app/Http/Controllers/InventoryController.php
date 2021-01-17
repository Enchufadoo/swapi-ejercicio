<?php

namespace App\Http\Controllers;

use App\Models\Inventory;
use Illuminate\Http\Request;

class InventoryController extends Controller
{
    public function count(string $type, int $id)
    {
        $client = new \GuzzleHttp\Client(['verify' => false]);

        $response = $client->request('GET', "https://swapi.dev/api/{$type}/${id}/", [
            'json' =>[]
        ]);

        $inventory = Inventory::where('external_id', $id)->first();

        if(!$inventory){
            $inventory = new Inventory(['external_id' => $id, 'count' => 0]);
        }

        return [
            'count' => $inventory->count
        ];
    }
}
