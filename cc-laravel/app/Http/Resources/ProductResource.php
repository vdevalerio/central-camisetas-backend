<?php

namespace App\Http\Resources;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class ProductResource extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @return array<string, mixed>
     */
    public function toArray(Request $request): array
    {
        return [
            'id' => $this->resource->id,
            'name' => $this->resource->name,
            'price' => $this->resource->price,
            'type' => $this->resource->type,
            'type_formatted' => $this->resource->type_formatted,
            'model' => $this->resource->model,
            'tissue' => $this->resource->tissue,
            'color' => $this->resource->color,
            'pocket' => $this->resource->pocket,
            'collar' => $this->resource->collar,
            'collar_formatted' => $this->resource->collar_formatted,
            'cuff' => $this->resource->cuff,
            'cuff_formatted' => $this->resource->cuff_formatted,
            'vivo' => $this->resource->vivo,
            'faixa' => $this->resource->faixa,
            'faixa_formatted' => $this->resource->faixa_formatted,
            'created_at' => $this->resource->created_at,
            'updated_at' => $this->resource->updated_at,
        ];
    }
}
