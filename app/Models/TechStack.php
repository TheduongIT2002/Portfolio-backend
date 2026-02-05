<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class TechStack extends Model
{
    /**
     * Các field cho phép gán hàng loạt
     */
    protected $fillable = [
        'category',
        'description',
        'items',
        'sort_order',
        'is_active',
    ];

    /**
     * Casts
     */
    protected $casts = [
        'items' => 'array',
        'sort_order' => 'integer',
        'is_active' => 'boolean',
    ];
}
