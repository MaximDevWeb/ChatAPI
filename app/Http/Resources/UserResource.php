<?php

namespace App\Http\Resources;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class UserResource extends JsonResource
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
            'login' => $this->login,
            'avatar' => AvatarResource::make($this->avatar),
            'profile' => ProfileResource::make($this->profile)
        ];
    }
}
