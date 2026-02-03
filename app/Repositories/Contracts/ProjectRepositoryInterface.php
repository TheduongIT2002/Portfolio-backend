<?php

namespace App\Repositories\Contracts;

use App\Models\Project;
use Illuminate\Pagination\LengthAwarePaginator;
use Illuminate\Database\Eloquent\Collection;

/**
 * Interface ProjectRepositoryInterface
 * Định nghĩa các phương thức cho Repository của Project
 */
interface ProjectRepositoryInterface
{
    /**
     * Lấy tất cả projects với phân trang
     *
     * @param int $perPage Số lượng items mỗi trang
     * @return LengthAwarePaginator
     */
    public function getAll(int $perPage = 15): LengthAwarePaginator;

    /**
     * Lấy project theo ID
     *
     * @param int $id
     * @return Project|null
     */
    public function findById(int $id): ?Project;

    /**
     * Tạo project mới
     *
     * @param array $data
     * @return Project
     */
    public function create(array $data): Project;

    /**
     * Cập nhật project
     *
     * @param int $id
     * @param array $data
     * @return Project
     */
    public function update(int $id, array $data): Project;

    /**
     * Xóa project (soft delete)
     *
     * @param int $id
     * @return bool
     */
    public function delete(int $id): bool;

    /**
     * Lấy các projects đang active
     *
     * @return Collection
     */
    public function getActiveProjects(): Collection;

    /**
     * Lấy các projects nổi bật
     *
     * @return Collection
     */
    public function getFeaturedProjects(): Collection;
}
