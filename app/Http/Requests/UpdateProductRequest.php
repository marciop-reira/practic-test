<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class UpdateProductRequest extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     *
     * @return bool
     */
    public function authorize()
    {
        return true;
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array
     */
    public function rules()
    {
        return [
            'name' => ['max:60', 'min:3'],
            'value' => ['integer', 'max:6', 'min:2'],
            'store_id' => ['exists:stores,id'],
            'active' => ['booelan'],
        ];
    }
}
