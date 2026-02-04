<?php

namespace App\Services;

use App\Models\Contact;
use App\Repositories\Contracts\ContactRepositoryInterface;
use Illuminate\Pagination\LengthAwarePaginator;

/**
 * Class ContactService
 * Service layer xử lý business logic cho Contact
 */
class ContactService
{
    /**
     * @var ContactRepositoryInterface
     */
    protected $repository;

    /**
     * ContactService constructor.
     *
     * @param ContactRepositoryInterface $repository
     */
    public function __construct(ContactRepositoryInterface $repository)
    {
        $this->repository = $repository;
    }

    /**
     * Lấy danh sách contacts với phân trang
     *
     * @param int $perPage
     * @return LengthAwarePaginator
     */
    public function getAllContacts(int $perPage = 10): LengthAwarePaginator
    {
        return $this->repository->getAll($perPage);
    }

    /**
     * Tạo contact mới từ dữ liệu form contact
     *
     * @param array $data
     * @return Contact
     */
    public function createContact(array $data): Contact
    {
        // Nếu không truyền source thì mặc định là 'portfolio'
        if (empty($data['source'])) {
            $data['source'] = 'portfolio';
        }

        // Mặc định status là new
        if (empty($data['status'])) {
            $data['status'] = 'new';
        }

        return $this->repository->create($data);
    }

    public function delete(int $id): bool
    {
        return $this->repository->delete($id);
    }

    /**
     * @param int $id
     * @param string $status
     * @return Contact
     */
    public function updateStatus(int $id, string $status): Contact
    {
        return $this->repository->update($id, ['status' => $status]);
    }
}

