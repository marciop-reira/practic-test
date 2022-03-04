<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class StoreProductRequest extends FormRequest
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
            'name' => ['required', 'max:60', 'min:3'],
            'value' => ['required', 'integer', 'max:6', 'min:2'],
            'store_id' => ['required', 'exists:stores,id'],
            'active' => ['required', 'booelan'],
        ];
    }
}
