<?php

namespace Database\Seeders;

use App\Models\PersonalInfo;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class PersonalInfoSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        // Tạo dữ liệu mẫu cho bảng personal_infos
        PersonalInfo::create([
            'full_name' => 'Dương',
            'slogan' => 'Backend Developer',
            'short_intro' => 'Xây dựng backend scalable và frontend tương tác. Ưu tiên clean code, tối ưu hiệu năng và giải quyết bài toán phức tạp.',
            'avatar' => '/avatars/avatar.jpg', 
            'cv_file' => '/file/CV_backend.pdf',        
            'email' => 'phantheduong@gmail.com',
            'phone' => '+84 349981685',
            'address' => 'Gia Lai, Việt Nam',
            'social_links' => [
                [
                    'type' => 'github',
                    'label' => 'GitHub',
                    'url' => 'https://github.com/username',
                    'url_icon' => 'https://img.icons8.com/?size=100&id=62856&format=png&color=000000',
                ],
                [
                    'type' => 'linkedin',
                    'label' => 'LinkedIn',
                    'url' => 'https://www.linkedin.com/in/username',
                    'url_icon' => 'https://img.icons8.com/?size=100&id=98960&format=png&color=000000',
                ],
            ],
        ]);
    }
}
