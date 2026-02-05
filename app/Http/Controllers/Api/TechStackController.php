<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Http\Resources\TechStackResource;
use App\Services\TechStackService;
use App\Traits\ApiResponse;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;

/**
 * Class TechStackController
 * Controller xử lý các API requests cho TechStack
 */
class TechStackController extends Controller
{
    use ApiResponse;

    /**
     * @var TechStackService
     */
    protected $techStackService;

    /**
     * TechStackController constructor.
     *
     * @param TechStackService $techStackService
     */
    public function __construct(TechStackService $techStackService)
    {
        $this->techStackService = $techStackService;
    }

    /**
     * Lấy danh sách tech stacks active (public - hiển thị main page)
     *
     * @return JsonResponse
     */
    public function getActiveList(): JsonResponse
    {
        try {
            $items = $this->techStackService->getActiveList();
            $data = $items->map(fn ($item) => (new TechStackResource($item))->resolve(request()))->all();

            return $this->successResponse($data, 'Lấy danh sách tech stack thành công');
        } catch (\Exception $e) {
            return $this->errorResponse('Lỗi khi lấy danh sách tech stack: ' . $e->getMessage(), 500);
        }
    }

    /**
     * Lấy danh sách tất cả tech stacks với phân trang (admin)
     *
     * @param Request $request
     * @return JsonResponse
     */
    public function index(Request $request): JsonResponse
    {
        try {
            $perPage = $request->get('per_page', 10);
            $techStacks = $this->techStackService->getAllTechStacks($perPage);

            /** @var \Illuminate\Pagination\LengthAwarePaginator $techStacks */
            $techStacks->setCollection(
                $techStacks->getCollection()->map(
                    fn ($item) => (new TechStackResource($item))->resolve($request)
                )
            );

            return $this->successResponse($techStacks, 'Lấy danh sách tech stack thành công');
        } catch (\Exception $e) {
            return $this->errorResponse('Lỗi khi lấy danh sách tech stack: ' . $e->getMessage(), 500);
        }
    }

    /**
     * Tạo tech stack mới
     *
     * @param Request $request
     * @return JsonResponse
     */
    public function create(Request $request): JsonResponse
    {
        try {
            $data = $request->all();
            $techStack = $this->techStackService->createTechStack($data);

            return $this->successResponse(
                new TechStackResource($techStack),
                'Tạo tech stack thành công',
                201
            );
        } catch (\Exception $e) {
            return $this->errorResponse('Lỗi khi tạo tech stack: ' . $e->getMessage(), 500);
        }
    }

    /**
     * Lấy thông tin tech stack theo ID
     *
     * @param string $id
     * @return JsonResponse
     */
    public function show(string $id): JsonResponse
    {
        try {
            $techStack = $this->techStackService->getTechStackById((int) $id);

            return $this->successResponse(
                new TechStackResource($techStack),
                'Lấy thông tin tech stack thành công'
            );
        } catch (\Exception $e) {
            $statusCode = $e->getCode() === 404 ? 404 : 500;
            return $this->errorResponse($e->getMessage(), $statusCode);
        }
    }

    /**
     * Cập nhật tech stack
     *
     * @param Request $request
     * @param string $id
     * @return JsonResponse
     */
    public function update(Request $request, string $id): JsonResponse
    {
        try {
            $data = $request->all();
            $techStack = $this->techStackService->updateTechStack((int) $id, $data);

            return $this->successResponse(
                new TechStackResource($techStack),
                'Cập nhật tech stack thành công'
            );
        } catch (\Exception $e) {
            $statusCode = $e->getCode() === 404 ? 404 : 500;
            return $this->errorResponse($e->getMessage(), $statusCode);
        }
    }

    /**
     * Xóa tech stack
     *
     * @param string $id
     * @return JsonResponse
     */
    public function delete(string $id): JsonResponse
    {
        try {
            $this->techStackService->deleteTechStack((int) $id);

            return $this->successResponse(null, 'Xóa tech stack thành công');
        } catch (\Exception $e) {
            $statusCode = $e->getCode() === 404 ? 404 : 500;
            return $this->errorResponse($e->getMessage(), $statusCode);
        }
    }
}
