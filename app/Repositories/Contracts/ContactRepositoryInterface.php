<?php

namespace App\Repositories\Contracts;

use App\Models\Contact;
use Illuminate\Pagination\LengthAwarePaginator;

/**
 * Interface ContactRepositoryInterface
 * Định nghĩa các phương thức cho Repository của Contact (form liên hệ)
 */
interface ContactRepositoryInterface
{
    /**
     * Lấy danh sách contacts với phân trang
     *
     * @param int $perPage
     * @return LengthAwarePaginator
     */
    public function getAll(int $perPage = 15): LengthAwarePaginator;

    /**
     * Tạo contact mới
     *
     * @param array $data
     * @return Contact
     */
    public function create(array $data): Contact;

    /**
     * Cập nhật trạng thái contact
     *
     * @param int $id
     * @param array $data
     * @return Contact
     */
    public function update(int $id, array $data): Contact;

    /**
     * Tìm contact theo ID
     *
     * @param int $id
     * @return Contact|null
     */
    public function findById(int $id): ?Contact;

    /**
     * Xóa contact theo ID
     *
     * @param int $id
     * @return bool
     */
    public function delete(int $id): bool;
}

