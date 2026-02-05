<?php

namespace App\Repositories\Contracts;

use App\Models\PersonalInfo;

/**
 * Interface PersonalInfoRepositoryInterface
 * Định nghĩa các phương thức truy xuất dữ liệu PersonalInfo
 */
interface PersonalInfoRepositoryInterface
{
    /**
     * Lấy bản ghi thông tin cá nhân (mặc định bản ghi đầu tiên)
     */
    public function getPersonalInfo(): ?PersonalInfo;

    /**
     * Tạo mới thông tin cá nhân
     */
    public function create(array $data): PersonalInfo;

    /**
     * Cập nhật thông tin cá nhân theo ID
     */
    public function update(int $id, array $data): PersonalInfo;
}

