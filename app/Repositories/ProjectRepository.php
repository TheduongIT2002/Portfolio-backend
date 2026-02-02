<?php

namespace App\Repositories;

use App\Models\Project;
use App\Repositories\Contracts\ProjectRepositoryInterface;
use Illuminate\Pagination\LengthAwarePaginator;
use Illuminate\Database\Eloquent\Collection;

/**
 * Class ProjectRepository
 * Implementation của ProjectRepositoryInterface
 * Xử lý các thao tác với database cho Project
 */
class ProjectRepository implements ProjectRepositoryInterface
{
    /**
     * @var Project
     */
    protected $model;

    /**
     * ProjectRepository constructor.
     *
     * @param Project $model
     */
    public function __construct(Project $model)
    {
        $this->model = $model;
    }

    /**
     * Lấy tất cả projects với phân trang
     *
     * @param int $perPage
     * @return LengthAwarePaginator
     */
    public function getAll(int $perPage = 15): LengthAwarePaginator
    {
        return $this->model
            ->orderBy('sort_order', 'asc')
            ->orderBy('created_at', 'desc')
            ->whereNull('deleted_at')
            ->paginate($perPage);
    }

    /**
     * Lấy project theo ID
     *
     * @param int $id
     * @return Project|null
     */
    public function findById(int $id): ?Project
    {
        return $this->model->find($id);
    }

    /**
     * Tạo project mới
     *
     * @param array $data
     * @return Project
     */
    public function create(array $data): Project
    {
        return $this->model->create($data);
    }

    /**
     * Cập nhật project
     *
     * @param int $id
     * @param array $data
     * @return Project
     */
    public function update(int $id, array $data): Project
    {
        $project = $this->findById($id);
        
        if (!$project) {
            throw new \Exception("Project not found");
        }

        $project->update($data);
        
        return $project->fresh();
    }

    /**
     * Xóa project (soft delete)
     *
     * @param int $id
     * @return bool
     */
    public function delete(int $id): bool
    {
        $project = $this->findById($id);
        
        if (!$project) {
            return false;
        }

        return $project->delete();
    }

    /**
     * Lấy các projects đang active
     *
     * @return Collection
     */
    public function getActiveProjects(): Collection
    {
        return $this->model
            ->where('is_active', true)
            ->orderBy('sort_order', 'asc')
            ->orderBy('created_at', 'desc')
            ->get();
    }

    /**
     * Lấy các projects nổi bật
     *
     * @return Collection
     */
    public function getFeaturedProjects(): Collection
    {
        return $this->model
            ->where('is_featured', true)
            ->where('is_active', true)
            ->orderBy('sort_order', 'asc')
            ->orderBy('created_at', 'desc')
            ->get();
    }
}
