<?php

namespace App\Http\Resources;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class OrderResource extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @return array<string, mixed>
     */
    public function toArray(Request $request): array
    {
        return [
            'id' => $this->id,
            'product_ids' => $this->product_ids,
            'status' => $this->status,
            'amount' => $this->amount,
            'user_id' => $this->user_id,
            'address_id' => $this->address_id,
            'invoices_id' => $this->invoices_id,
        ];
    }
}
