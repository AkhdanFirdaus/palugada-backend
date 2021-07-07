<?php

namespace App\Http\Resources;

use Illuminate\Http\Resources\Json\JsonResource;

class WebinarDetailResource extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return array
     */
    public function toArray($request)
    {
        return [
            $this->merge(new WebinarResource($this['webinar'])),
            'pendaftar' => UserResource::collection($this['pendaftar']),
            'narasumber' => UserResource::collection($this['narasumber']),
        ];
    }
}
