<?php


namespace App\Models;


use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Inventory extends Model
{
    use HasFactory;

    protected $keyType = 'integer';

    protected $fillable = ['count', 'external_id'];

    public static function getOrCreate(int $id, int $count)
    {
        $inventory = self::where('external_id', $id)->first();

        if(!$inventory){
            $inventory = new Inventory(['external_id' => $id, 'count' => $count]);
        }

        return $inventory;
    }
}
