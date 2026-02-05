<?php

namespace App\Repositories;

use App\Models\PersonalInfo;
use App\Repositories\Contracts\PersonalInfoRepositoryInterface;

/**
 * Class PersonalInfoRepository
 * Implementation cho PersonalInfoRepositoryInterface
 */
class PersonalInfoRepository implements PersonalInfoRepositoryInterface
{
    /**
     * @var PersonalInfo
     */
    protected $model;

    public function __construct(PersonalInfo $model)
    {
        $this->model = $model;
    }

    /**
     * Lấy bản ghi thông tin cá nhân (bản ghi đầu tiên)
     */
    public function getPersonalInfo(): ?PersonalInfo
    {
        return $this->model->first();
    }

    /**
     * Tạo mới thông tin cá nhân
     */
    public function create(array $data): PersonalInfo
    {
        return $this->model->create($data);
    }

    /**
     * Cập nhật thông tin cá nhân
     */
    public function update(int $id, array $data): PersonalInfo
    {
        $info = $this->model->findOrFail($id);
        $info->update($data);

        return $info->fresh();
    }
}

