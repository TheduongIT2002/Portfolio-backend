<?php

namespace App\Repositories\Contracts;

use App\Models\TechStack;
use Illuminate\Pagination\LengthAwarePaginator;
use Illuminate\Database\Eloquent\Collection;

/**
 * Interface TechStackRepositoryInterface
 * Định nghĩa các phương thức cho Repository của TechStack
 */
interface TechStackRepositoryInterface
{
    /**
     * Lấy danh sách tech stacks với phân trang (admin)
     */
    public function getAll(int $perPage = 10): LengthAwarePaginator;

    /**
     * Lấy danh sách tech stacks active (public)
     */
    public function getActiveList(): Collection;

    /**
     * Tạo mới
     */
    public function create(array $data): TechStack;

    /**
     * Cập nhật
     */
    public function update(int $id, array $data): TechStack;

    /**
     * Xóa
     */
    public function delete(int $id): bool;

    /**
     * Tìm theo ID
     */
    public function findById(int $id): ?TechStack;
}

