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

    /**
     * Set the user's first name.
     *
     * @param  string  $value
     * @return void
     */
    public function setCountAttribute($value)
    {
        if($value < 0){
            throw new \Exception('Count can\'t be less than 0');
        }
        $this->attributes['count'] = $value;
    }
}
