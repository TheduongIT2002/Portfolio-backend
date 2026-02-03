<?php

namespace App\Services;

use Illuminate\Http\UploadedFile;
use App\Repositories\Contracts\ProjectRepositoryInterface;
use Illuminate\Pagination\LengthAwarePaginator;
use Illuminate\Database\Eloquent\Collection;
use Illuminate\Support\Facades\Storage;

/**
 * Class ProjectService
 * Service layer xử lý business logic cho Project
 */
class ProjectService
{
    /**
     * @var ProjectRepositoryInterface
     */
    protected $repository;

    /**
     * ProjectService constructor.
     *
     * @param ProjectRepositoryInterface $repository
     */
    public function __construct(ProjectRepositoryInterface $repository)
    {
        $this->repository = $repository;
    }

    /**
     * Lấy danh sách tất cả projects
     *
     * @param int $perPage
     * @return LengthAwarePaginator
     */
    public function getAllProjects(int $perPage = 15): LengthAwarePaginator
    {
        return $this->repository->getAll($perPage);
    }

    /**
     * Lấy project theo ID
     *
     * @param int $id
     * @return \App\Models\Project
     * @throws \Exception
     */
    public function getProjectById(int $id): \App\Models\Project
    {
        $project = $this->repository->findById($id);
        
        if (!$project) {
            throw new \Exception("Project not found", 404);
        }

        return $project;
    }

    /**
     * Tạo project mới
     *
     * @param array $data
     * @return \App\Models\Project
     */
    public function createProject(array $data): \App\Models\Project
    {
        return $this->repository->create($data);
    }

    /**
     * Upload ảnh project lên disk public và trả về path để lưu DB
     *
     * @param UploadedFile $file
     * @return string
     */
    public function storeProjectImage(UploadedFile $file): string
    {
        // Lưu file vào storage/app/public/projects
        return $file->store('projects', 'public');
    }

    /**
     * Replace ảnh project: upload ảnh mới, xóa ảnh cũ (nếu có) và trả về path ảnh mới
     *
     * @param UploadedFile $file
     * @param string|null $oldPath
     * @return string
     */
    public function replaceProjectImage(UploadedFile $file, ?string $oldPath = null): string
    {
        $newPath = $this->storeProjectImage($file);

        // Xóa ảnh cũ để tránh rác trong storage (chỉ xóa nếu tồn tại)
        if (!empty($oldPath) && Storage::disk('public')->exists($oldPath)) {
            Storage::disk('public')->delete($oldPath);
        }

        return $newPath;
    }

    /**
     * Cập nhật project
     *
     * @param int $id
     * @param array $data
     * @return \App\Models\Project
     * @throws \Exception
     */
    public function updateProject(int $id, array $data): \App\Models\Project
    {
        $project = $this->repository->findById($id);
        
        if (!$project) {
            throw new \Exception("Project not found", 404);
        }

        return $this->repository->update($id, $data);
    }

    /**
     * Xóa project
     *
     * @param int $id
     * @return bool
     * @throws \Exception
     */
    public function deleteProject(int $id): bool
    {
        $project = $this->repository->findById($id);
        
        if (!$project) {
            throw new \Exception("Project not found", 404);
        }

        return $this->repository->delete($id);
    }

    /**
     * Lấy các projects đang active
     *
     * @return Collection
     */
    public function getActiveProjects(): Collection
    {
        return $this->repository->getActiveProjects();
    }

    /**
     * Lấy các projects nổi bật
     *
     * @return Collection
     */
    public function getFeaturedProjects(): Collection
    {
        return $this->repository->getFeaturedProjects();
    }
}
