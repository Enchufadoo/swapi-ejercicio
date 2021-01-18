<?php

namespace App\Http\Controllers;

use App\Http\Requests\CountRequest;
use App\Http\Requests\SetAmountRequest;
use App\Http\Requests\SetDecrementRequest;
use App\Http\Requests\SetIncrementRequest;
use App\Http\SwapiApi;
use App\Models\Inventory;
use Illuminate\Http\Request;
use phpDocumentor\Reflection\Types\Integer;

class InventoryController extends Controller
{

    /**
     * Devuelve la cantidad de unidades para un tipo de vehiculo en particular
     */
    public function count(CountRequest $request, string $type, int $id)
    {
        $swapiApi = new SwapiApi();
        $swapiApi->getVehicle($type, $id);

        $inventory = Inventory::getOrCreate($id, $type,0);

        return [
            'count' => $inventory->count
        ];
    }

    /**
     * Establece la cantidad de elementos de un vehiculo
     */
    public function setAmount(SetAmountRequest $request, string $type, int $id)
    {
        $amount = $request->post('amount');

        $swapiApi = new SwapiApi();
        $swapiApi->getVehicle($type, $id);

        $inventory = Inventory::getOrCreate($id, $type, 0);
        $inventory->count = $amount;
        $inventory->save();

        return [];
    }

    /**
     * Incrementa la cantidad de elementos de un vehiculo
     */
    public function increment(SetIncrementRequest $request, string $type, int $id)
    {
        $amount = $request->post('amount');

        $swapiApi = new SwapiApi();
        $swapiApi->getVehicle($type, $id);

        $inventory = Inventory::getOrCreate($id, $type, 0);
        $inventory->count = $inventory->count + $amount;
        $inventory->save();

        return [];
    }

    /**
     * Decrementa en unidades la cantidad de elementos de un vehiculo
     */
    public function decrement(SetDecrementRequest $request, string $type, int $id)
    {
        $amount = $request->post('amount');

        $swapiApi = new SwapiApi();
        $swapiApi->getVehicle($type, $id);

        $inventory = Inventory::getOrCreate($id, $type, 0);
        $inventory->count = $inventory->count - $amount;
        $inventory->save();

        return [];
    }

}
