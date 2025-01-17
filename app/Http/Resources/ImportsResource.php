<?php

namespace App\Http\Resources;

use Illuminate\Http\Resources\Json\JsonResource;

class ImportsResource extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return array|\Illuminate\Contracts\Support\Arrayable|\JsonSerializable
     */
    public function toArray($request)
    {
        return [
            'id' => $this->id,
            'dealer'=> $this->dealer->name,
            'bill_number'=> $this->bill_number,
            'shipping_charge_price'=> $this->shipping_charge_price,
            'total_price'=> $this->total_price,
            'product'=>$this->products
        ];    
    }
}
