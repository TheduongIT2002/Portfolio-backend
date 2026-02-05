<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     */
    public function run(): void
    {
        // Seeder dữ liệu mẫu cho thông tin cá nhân
        $this->call(PersonalInfoSeeder::class);
    }
}
