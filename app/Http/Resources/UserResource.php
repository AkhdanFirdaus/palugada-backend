<?php

namespace App\Http\Resources;

use Illuminate\Http\Resources\Json\JsonResource;

class UserResource extends JsonResource
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
            'id' => $this->id,
            'name' => $this->name,
            'email' => $this->email,
            'nomor_telp' => $this->nomor_telp,
            'asal' => $this->asal,
            'role' => $this->role,
            $this->mergeWhen(isset($this->count_webinar), [
                'count_webinar' => $this->count_webinar
            ]),
        ];
    }
}
