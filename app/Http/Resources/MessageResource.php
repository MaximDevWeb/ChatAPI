<?php

namespace App\Http\Resources;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class MessageResource extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @param  Request  $request
     * @return array
     */
    public function toArray($request): array
    {
        return [
            'id' => $this->id,
            'user' => new MessageUserResource($this->user),
            'type' => $this->type,
            'text' => $this->text,
            'file' => new FileResource($this->file),
            'created_at' => $this->created_at,
        ];
    }
}
