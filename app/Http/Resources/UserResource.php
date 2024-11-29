<?php

namespace App\Http\Resources;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class UserResource extends JsonResource
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
            'name'=>$this->name,
            'email'=>$this->email,
            'phone'=>$this->phone,
            'location'=>$this->location,
            'address'=>$this->address,
            'organization_name' => $this->organization_name,
            'organization_category' => $this->organization_category,
            'created_at'=>$this->created_at,
            'updated_at'=>$this->updated_at,
            'role'=>$this->getRoleNames(),
            'profile_image' => $this->getFirstMediaUrl('profile_image') ?  $this->getFirstMediaUrl('profile_image') : null,
            'organization_logo' => $this->getFirstMediaUrl('organization_logo') ?  $this->getFirstMediaUrl('organization_logo') : null,
            
            
        ];
    }
}