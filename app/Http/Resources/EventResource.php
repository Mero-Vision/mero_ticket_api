<?php

namespace App\Http\Resources;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class EventResource extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @return array<string, mixed>
     */
    public function toArray(Request $request): array
    {
        return [
            'id'=>$this->id,
            'user_id'=>$this->user_id,
            'title'=>$this->title,
            'description'=>$this->description,
            'start_date'=>$this->start_date,
            'end_date'=>$this->end_date,
            'start_time'=>$this->start_time,
            'end_time'=>$this->end_time,
            'address'=>$this->address,
            'event_image' => $this->getFirstMediaUrl('event_image') ?  $this->getFirstMediaUrl('event_image') : null,
            'vendors'=>EventVendorResource::collection($this->whenLoaded('eventVendors'))
        ];
    }
}