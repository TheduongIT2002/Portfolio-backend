<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    /**
     * Run the migrations.
     * Tạo bảng projects để lưu trữ thông tin các dự án portfolio
     */
    public function up(): void
    {
        Schema::create('projects', function (Blueprint $table) {
            $table->id();
            $table->string('title'); // Tiêu đề dự án
            $table->text('description')->nullable(); // Mô tả dự án
            $table->string('image')->nullable(); // Hình ảnh dự án
            $table->string('url')->nullable(); // URL dự án
            $table->string('github_url')->nullable(); // URL GitHub
            $table->json('technologies')->nullable(); // Các công nghệ sử dụng (JSON array)
            $table->date('start_date')->nullable(); // Ngày bắt đầu
            $table->date('end_date')->nullable(); // Ngày kết thúc
            $table->boolean('is_featured')->default(false); // Dự án nổi bật
            $table->integer('sort_order')->default(0); // Thứ tự sắp xếp
            $table->boolean('is_active')->default(true); // Trạng thái hoạt động
            $table->timestamps();
            $table->softDeletes(); // Soft delete
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('projects');
    }
};
