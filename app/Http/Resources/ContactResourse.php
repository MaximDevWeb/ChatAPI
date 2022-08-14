<?php

namespace App\Http\Resources;

use Illuminate\Http\Resources\Json\JsonResource;

class ContactResourse extends JsonResource
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
            'contact_id' => $this->contact_id,
            'login' => $this->contact_user->login,
            'full_name' => $this->contact_user->profile->first_name . ' ' . $this->contact_user->profile->last_name,
            'avatar' => $this->contact_user->avatar->link
        ];
    }
}
