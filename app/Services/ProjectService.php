<?php

namespace App\Services;

use App\Repositories\Contracts\ProjectRepositoryInterface;
use Illuminate\Contracts\Pagination\LengthAwarePaginator;
use Illuminate\Database\Eloquent\Collection;

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
