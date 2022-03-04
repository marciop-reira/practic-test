<?php

namespace App\Http\Resources;

use Illuminate\Http\Resources\Json\JsonResource;

/**
 *
 */
class ProductResource extends JsonResource
{
    /**
     * @param $request
     * @return array
     */
    public function toArray($request)
    {
        return [
            'id' => $this->id,
            'store_id' => $this->store_id,
            'name' => $this->name,
            'value' => 'R$ '.number_format($this->value, 2, ',', ''),
            'active' => $this->active,
            'store' => $this->store,
        ];
    }
}
