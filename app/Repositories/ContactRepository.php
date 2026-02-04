<?php

namespace App\Repositories;

use App\Models\Contact;
use App\Repositories\Contracts\ContactRepositoryInterface;
use Illuminate\Pagination\LengthAwarePaginator;

/**
 * Class ContactRepository
 */
class ContactRepository implements ContactRepositoryInterface
{
    /**
     * @var Contact
     */
    protected $model;

    /**
     * ContactRepository constructor.
     *
     * @param Contact $model
     */
    public function __construct(Contact $model)
    {
        $this->model = $model;
    }

    /**
     * Lấy danh sách contacts với phân trang
     */
    public function getAll(int $perPage = 15): LengthAwarePaginator
    {
        return $this->model
            ->orderBy('created_at', 'desc')
            ->paginate($perPage);
    }

    /**
     * Tạo contact mới
     */
    public function create(array $data): Contact
    {
        return $this->model->create($data);
    }

    /**
     * Cập nhật contact theo ID
     */
    public function update(int $id, array $data): Contact
    {
        $contact = $this->findById($id);

        if (!$contact) {
            throw new \Exception('Contact not found');
        }

        $contact->update($data);

        return $contact->fresh();
    }
    
    /**
     * Xóa contact theo ID
     */
    public function delete(int $id): bool
    {
        $contact = $this->findById($id);
        return $contact->delete();
    }

    /**
     * Tìm contact theo ID
     */
    public function findById(int $id): ?Contact
    {
        return $this->model->find($id);
    }
}

