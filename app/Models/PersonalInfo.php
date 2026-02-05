<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class PersonalInfo extends Model
{
    /**
     * Các field có thể fill
     */
    protected $fillable = [
        'full_name',
        'slogan',
        'short_intro',
        'avatar',
        'cv_file',
        'email',
        'phone',
        'address',
        'social_links',
    ];

    /**
     * Casts
     */
    protected $casts = [
        'social_links' => 'array',
    ];
}
