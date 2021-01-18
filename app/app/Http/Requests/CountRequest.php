<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class CountRequest extends FormRequest
{
    protected function baseRules(){
        return [
            'id' => 'required|numeric|min:1',
            'type' => 'in:vehicles,starships'
        ];
    }

    public function rules()
    {
        return $this->baseRules();
    }

    public function all($keys = null)
    {
        return array_merge(parent::all(), $this->route()->parameters());
    }
}
