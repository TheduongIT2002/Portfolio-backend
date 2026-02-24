<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

/**
 * Model Project - Quản lý thông tin các dự án portfolio
 */
class Project extends Model
{
    use SoftDeletes;

    /**
     * Các trường có thể fill
     */
    protected $fillable = [
        'title',
        'description',
        'image',
        'url',
        'github_url',
        'technologies',
        'start_date',
        'end_date',
        'is_featured',
        'sort_order',
        'is_active',

    ];

    /**
     * Các trường sẽ được cast sang kiểu dữ liệu phù hợp
     */
    protected $casts = [
        'technologies' => 'array',
        'is_featured' => 'boolean',
        'is_active' => 'boolean',
        'start_date' => 'date',
        'end_date' => 'date',
        'sort_order' => 'integer',
    ];
}
