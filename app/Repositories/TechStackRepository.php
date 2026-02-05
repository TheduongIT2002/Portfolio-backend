<?php

namespace App\Repositories;

use App\Models\TechStack;
use App\Repositories\Contracts\TechStackRepositoryInterface;
use Illuminate\Database\Eloquent\Collection;
use Illuminate\Pagination\LengthAwarePaginator;

/**
 * Class TechStackRepository
 * Implementation của TechStackRepositoryInterface
 */
class TechStackRepository implements TechStackRepositoryInterface
{
    /**
     * @var TechStack
     */
    protected $model;

    public function __construct(TechStack $model)
    {
        $this->model = $model;
    }

    public function index(int $perPage = 10): LengthAwarePaginator
    {
        return $this->model
            ->orderBy('sort_order', 'asc')
            ->orderBy('created_at', 'desc')
            ->paginate($perPage);
    }

    public function getActiveList(): Collection
    {
        return $this->model
            ->where('is_active', true)
            ->orderBy('sort_order', 'asc')
            ->orderBy('created_at', 'desc')
            ->get();
    }

    public function create(array $data): TechStack
    {
        return $this->model->create($data);
    }

    public function update(int $id, array $data): TechStack
    {
        $item = $this->show($id);
        if (!$item) {
            throw new \Exception('Tech stack not found', 404);
        }

        $item->update($data);

        return $item->fresh();
    }

    public function delete(int $id): bool
    {
        $item = $this->show($id);
        if (!$item) {
            return false;
        }

        return (bool) $item->delete();
    }

    public function show(int $id): ?TechStack
    {
        return $this->model->find($id);
    }
}

