<?php

namespace App\Http\Controllers;

use App\Http\Requests\CountRequest;
use App\Http\Requests\SetAmountRequest;
use App\Http\Requests\SetIncrementRequest;
use App\Models\Inventory;
use Illuminate\Http\Request;
use phpDocumentor\Reflection\Types\Integer;

class InventoryController extends Controller
{


    public function count(CountRequest $request, string $type, int $id)
    {

        $client = new \GuzzleHttp\Client(['verify' => false]);

        $response = $client->request('GET', "https://swapi.dev/api/{$type}/${id}/", [
            'json' =>[]
        ]);

        $inventory = Inventory::getOrCreate($id, 0);

        return [
            'count' => $inventory->count
        ];
    }

    public function setAmount(SetAmountRequest $request, string $type, int $id)
    {
        $amount = $request->post('amount');

        $inventory = Inventory::getOrCreate($id, 0);
        $inventory->count = $amount;
        $inventory->save();

        return [];
    }

    public function increment(SetIncrementRequest $request, string $type, int $id)
    {
        $amount = $request->post('amount');

        $inventory = Inventory::getOrCreate($id, 0);
        $inventory->count = $inventory->count + $amount;
        $inventory->save();

        return [];
    }

    public function decrement(Request $request, string $type, int $id)
    {
        $amount = $request->post('amount');

        $inventory = Inventory::getOrCreate($id, 0);
        $inventory->count = $inventory->count - $amount;
        $inventory->save();

        return [];
    }

}
