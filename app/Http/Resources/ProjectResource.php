<?php

namespace App\Http\Resources;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

/**
 * Resource cho Project
 * Mục tiêu: gom toàn bộ format response của Project về 1 chỗ để dễ custom sau này
 */
class ProjectResource extends JsonResource
{
    /**
     * Tắt wrap mặc định "data" của JsonResource để tránh lồng data trong ApiResponse
     *
     * @var string|null
     */
    public static $wrap = null;

    /**
     * Transform resource thành array
     *
     * @param Request $request
     * @return array<string, mixed>
     */
    public function toArray(Request $request): array
    {
        return [
            'id' => $this->id,
            'title' => $this->title,
            'description' => $this->description,
            'image' => $this->image,
            'image_url' => !empty($this->image) ? '/storage/' . ltrim($this->image, '/') : null,
            'url' => $this->url,
            'github_url' => $this->github_url,
            'technologies' => $this->technologies,

            'start_date' => $this->start_date,
            'end_date' => $this->end_date,

            'is_featured' => (bool) $this->is_featured,
            'sort_order' => (int) $this->sort_order,
            'is_active' => (bool) $this->is_active,

            'created_at' => $this->created_at,
            'updated_at' => $this->updated_at,
        ];
    }
}

