<?php

namespace App\Http\Resources;

use Illuminate\Http\Resources\Json\JsonResource;

class TaskResource extends JsonResource
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
            'id'           => $this->id,
            'title'        => $this->title,
            'description'  => $this->description,
            'start'        => $this->start,
            'end'          => $this->end,
            'is_private'   => $this->is_private,
            'expected_end' => $this->expected_end,
            'created_at'   => date('d-m-Y H:i', strtotime($this->created_at)),
            'updated_at'   => $this->updated_at,
            'user'         => $this->user->name
        ];
    }
}
