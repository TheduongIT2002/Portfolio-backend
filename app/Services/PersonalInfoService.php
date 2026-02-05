<?php

namespace App\Services;

use App\Models\PersonalInfo;
use App\Repositories\Contracts\PersonalInfoRepositoryInterface;
use Illuminate\Support\Facades\Storage;

/**
 * Class PersonalInfoService
 * Xử lý business logic cho thông tin cá nhân (profile)
 */
class PersonalInfoService
{
    /**
     * @var PersonalInfoRepositoryInterface
     */
    protected $repository;

    public function __construct(PersonalInfoRepositoryInterface $repository)
    {
        $this->repository = $repository;
    }

    /**
     * Lấy thông tin cá nhân (bản ghi đầu tiên)
     */
    public function getPersonalInfo(): ?PersonalInfo
    {
        return $this->repository->getPersonalInfo();
    }

    /**
     * Tạo mới hoặc cập nhật thông tin cá nhân
     * - Nếu chưa có bản ghi -> create
     * - Nếu đã có -> update
     */
    public function upsertPersonalInfo(array $data): PersonalInfo
    {
        $existing = $this->repository->getPersonalInfo();

        if ($existing) {
            return $this->repository->update($existing->id, $data);
        }

        return $this->repository->create($data);
    }

    /**
     * Lưu file avatar và trả về path lưu trong DB
     */
    public function storeAvatar(\Illuminate\Http\UploadedFile $file, ?string $oldPath = null): string
    {
        $path = $file->store('personal/avatar', 'public');

        if ($oldPath && Storage::disk('public')->exists($oldPath)) {
            Storage::disk('public')->delete($oldPath);
        }

        return $path;
    }

    /**
     * Lưu file CV và trả về path lưu trong DB
     */
    public function storeCvFile(\Illuminate\Http\UploadedFile $file, ?string $oldPath = null): string
    {
        $path = $file->store('personal/cv', 'public');

        if ($oldPath && Storage::disk('public')->exists($oldPath)) {
            Storage::disk('public')->delete($oldPath);
        }

        return $path;
    }
}

