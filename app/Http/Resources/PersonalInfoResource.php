<?php

namespace App\Http\Resources;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class PersonalInfoResource extends JsonResource
{
    public static $wrap = null;

    /**
     * Transform the resource into an array.
     *
     * @return array<string, mixed>
     */
    public function toArray(Request $request): array
    {
        return [
            'id' => $this->id,
            'full_name' => $this->full_name,
            'slogan' => $this->slogan,
            'short_intro' => $this->short_intro,
            'avatar' => $this->avatar,
            // URL public cho avatar
            'avatar_url' => !empty($this->avatar)? '/storage/' . ltrim($this->avatar, '/') : null,
            'cv_file' => $this->cv_file,
            'cv_url' => !empty($this->cv_file)? '/storage/' . ltrim($this->cv_file, '/') : null,
            'email' => $this->email,
            'phone' => $this->phone,
            'address' => $this->address,
            'social_links' => $this->social_links ?? [],
            'created_at' => $this->created_at,
            'updated_at' => $this->updated_at,
        ];
    }
}
