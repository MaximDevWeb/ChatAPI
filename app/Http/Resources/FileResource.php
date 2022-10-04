<?php

namespace App\Http\Resources;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class FileResource extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @param  Request  $request
     * @return array
     */
    public function toArray($request): array
    {
        $info = pathinfo($this->link);

        return [
            'id' => $this->id,
            'original_name' => $this->original_name,
            'extension' => $info['extension'],
            'preview' => 'https://ik.imagekit.io/ipn6vplwc/tr:w-600/' . $info['basename'],
            'link' => $this->link
        ];
    }
}
