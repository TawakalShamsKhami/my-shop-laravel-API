<?php

namespace App\Http\Resources;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class CompanyResource extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @return array<string, mixed>
     */
    public function toArray(Request $request): array
    {
            return [
            // 'id' => $this->id,
            'name' => $this->name,
            // 'created_by' => $this->created_by,
            'status' => $this->status,
            'created_at' => $this->created_at?->format('Y-m-d H:i:s'),
            'address' => $this->address,
            'licence_number' => $this->licence_number,
            'tin_number' => $this->tin_number,
            'phone' => $this->phone,
            'email' => $this->email,
        ];
    }
}
