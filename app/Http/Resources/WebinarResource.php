<?php

namespace App\Http\Resources;

use Illuminate\Http\Resources\Json\JsonResource;
use App\Http\Resources\UserResource;

use function PHPUnit\Framework\isEmpty;

class WebinarResource extends JsonResource
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
            'webinar_id' => $this->webinar_id,
            'nama' => $this->nama,
            'deskripsi' => $this->deskripsi,
            'kuota' => $this->kuota,
            'tanggal' => $this->tanggal,
            'jam_mulai' => $this->jam_mulai,
            'jam_selesai' => $this->jam_selesai,
            'link' => $this->link,
            'penyelenggara' => new UserResource($this),
        ];
    }
}
