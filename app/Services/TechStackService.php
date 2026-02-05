<?php

namespace App\Services;

use App\Models\TechStack;
use App\Repositories\Contracts\TechStackRepositoryInterface;
use Illuminate\Pagination\LengthAwarePaginator;
use Illuminate\Database\Eloquent\Collection;

/**
 * Class TechStackService
 * Service layer xử lý business logic cho TechStack
 */
class TechStackService
{
    /**
     * @var TechStackRepositoryInterface
     */
    protected $repository;

    /**
     * TechStackService constructor.
     *
     * @param TechStackRepositoryInterface $repository
     */
    public function __construct(TechStackRepositoryInterface $repository)
    {
        $this->repository = $repository;
    }

    /**
     * Lấy danh sách tech stacks với phân trang (admin)
     *
     * @param int $perPage
     * @return LengthAwarePaginator
     */
    public function getAllTechStacks(int $perPage = 10): LengthAwarePaginator
    {
        return $this->repository->index($perPage);
    }

    /**
     * Lấy danh sách tech stacks active (public)
     *
     * @return Collection
     */
    public function getActiveList(): Collection
    {
        return $this->repository->getActiveList();
    }

    /**
     * Tạo tech stack mới
     *
     * @param array $data
     * @return TechStack
     */
    public function createTechStack(array $data): TechStack
    {
        return $this->repository->create($data);
    }

    /**
     * Lấy tech stack theo ID
     *
     * @param int $id
     * @return TechStack
     * @throws \Exception
     */
    public function getTechStackById(int $id): TechStack
    {
        $techStack = $this->repository->show($id);
        
        if (!$techStack) {
            throw new \Exception('Tech stack not found', 404);
        }

        return $techStack;
    }

    /**
     * Cập nhật tech stack
     *
     * @param int $id
     * @param array $data
     * @return TechStack
     * @throws \Exception
     */
    public function updateTechStack(int $id, array $data): TechStack
    {
        $techStack = $this->repository->show($id);
        
        if (!$techStack) {
            throw new \Exception('Tech stack not found', 404);
        }

        return $this->repository->update($id, $data);
    }

    /**
     * Xóa tech stack
     *
     * @param int $id
     * @return bool
     * @throws \Exception
     */
    public function deleteTechStack(int $id): bool
    {
        $techStack = $this->repository->show($id);
        
        if (!$techStack) {
            throw new \Exception('Tech stack not found', 404);
        }

        return $this->repository->delete($id);
    }
}
