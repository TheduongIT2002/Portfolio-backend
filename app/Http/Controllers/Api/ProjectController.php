<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Http\Requests\StoreProjectRequest;
use App\Http\Requests\UpdateProjectRequest;
use App\Services\ProjectService;
use App\Traits\ApiResponse;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;

/**
 * Class ProjectController
 * Controller xử lý các API requests cho Project
 */
class ProjectController extends Controller
{
    use ApiResponse;

    /**
     * @var ProjectService
     */
    protected $projectService;

    /**
     * ProjectController constructor.
     *
     * @param ProjectService $projectService
     */
    public function __construct(ProjectService $projectService)
    {
        $this->projectService = $projectService;
    }

    /**
     * Lấy danh sách tất cả projects
     *
     * @param Request $request
     * @return JsonResponse
     */
    public function index(Request $request): JsonResponse
    {
        try {
            $perPage = $request->get('per_page', 15);
            $projects = $this->projectService->getAllProjects($perPage);

            return $this->successResponse($projects, 'Lấy danh sách projects thành công');
        } catch (\Exception $e) {
            return $this->errorResponse('Lỗi khi lấy danh sách projects: ' . $e->getMessage(), 500);
        }
    }

    /**
     * Tạo project mới
     *
     * @param StoreProjectRequest $request
     * @return JsonResponse
     */
    public function store(StoreProjectRequest $request): JsonResponse
    {
        try {
            $project = $this->projectService->createProject($request->validated());

            return $this->successResponse($project, 'Tạo project thành công', 201);
        } catch (\Exception $e) {
            return $this->errorResponse('Lỗi khi tạo project: ' . $e->getMessage(), 500);
        }
    }

    /**
     * Lấy thông tin project theo ID
     *
     * @param string $id
     * @return JsonResponse
     */
    public function show(string $id): JsonResponse
    {
        try {
            $project = $this->projectService->getProjectById((int) $id);

            return $this->successResponse($project, 'Lấy thông tin project thành công');
        } catch (\Exception $e) {
            $statusCode = $e->getCode() === 404 ? 404 : 500;
            return $this->errorResponse($e->getMessage(), $statusCode);
        }
    }

    /**
     * Cập nhật project
     *
     * @param UpdateProjectRequest $request
     * @param string $id
     * @return JsonResponse
     */
    public function update(UpdateProjectRequest $request, string $id): JsonResponse
    {
        try {
            $project = $this->projectService->updateProject((int) $id, $request->validated());

            return $this->successResponse($project, 'Cập nhật project thành công');
        } catch (\Exception $e) {
            $statusCode = $e->getCode() === 404 ? 404 : 500;
            return $this->errorResponse($e->getMessage(), $statusCode);
        }
    }

    /**
     * Xóa project
     *
     * @param string $id
     * @return JsonResponse
     */
    public function destroy(string $id): JsonResponse
    {
        try {
            $this->projectService->deleteProject((int) $id);

            return $this->successResponse(null, 'Xóa project thành công');
        } catch (\Exception $e) {
            $statusCode = $e->getCode() === 404 ? 404 : 500;
            return $this->errorResponse($e->getMessage(), $statusCode);
        }
    }

    /**
     * Lấy danh sách các projects đang active
     *
     * @return JsonResponse
     */
    public function getActiveProjects(): JsonResponse
    {
        try {
            $projects = $this->projectService->getActiveProjects();

            return $this->successResponse($projects, 'Lấy danh sách projects active thành công');
        } catch (\Exception $e) {
            return $this->errorResponse('Lỗi khi lấy danh sách projects active: ' . $e->getMessage(), 500);
        }
    }

    /**
     * Lấy danh sách các projects nổi bật
     *
     * @return JsonResponse
     */
    public function getFeaturedProjects(): JsonResponse
    {
        try {
            $projects = $this->projectService->getFeaturedProjects();

            return $this->successResponse($projects, 'Lấy danh sách projects nổi bật thành công');
        } catch (\Exception $e) {
            return $this->errorResponse('Lỗi khi lấy danh sách projects nổi bật: ' . $e->getMessage(), 500);
        }
    }
}
