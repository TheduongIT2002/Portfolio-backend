<?php

return [
    /*
    |--------------------------------------------------------------------------
    | Cross-Origin Resource Sharing (CORS) Configuration
    |--------------------------------------------------------------------------
    |
    | Cấu hình CORS để cho phép frontend gọi API từ origin khác
    |
    */

    'paths' => ['api/*', 'sanctum/csrf-cookie'],

    'allowed_methods' => ['*'], // Cho phép tất cả methods bao gồm OPTIONS

    'allowed_origins' => [
        'http://localhost:3000',
        'http://127.0.0.1:3000',
        'http://localhost:5173', // Vite dev server
        'http://127.0.0.1:5173',
    ],

    'allowed_origins_patterns' => [],

    'allowed_headers' => ['*'], // Cho phép tất cả headers bao gồm Content-Type cho FormData

    'max_age' => 86400, // Cache preflight requests trong 24 giờ

    'supports_credentials' => true,
];
