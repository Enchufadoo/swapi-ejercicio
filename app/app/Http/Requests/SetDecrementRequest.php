<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class SetDecrementRequest extends CountRequest
{
    public function rules()
    {
        return array_merge($this->baseRules(), [
            'amount' => 'required|numeric|min:1'
        ]);
    }
}
