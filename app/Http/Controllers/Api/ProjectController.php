<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Http\Requests\StoreProjectRequest;
use App\Http\Requests\UpdateProjectRequest;
use App\Http\Resources\ProjectResource;
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
            /** @var \Illuminate\Pagination\LengthAwarePaginator $projects */

            // Transform items bằng Resource nhưng vẫn giữ cấu trúc paginator như cũ
            $projects->setCollection(
                $projects->getCollection()->map(fn ($project) => (new ProjectResource($project))->resolve($request))
            );

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
            $data = $request->validated();

            // Nếu có upload ảnh thì lưu file và lấy path để lưu DB
            if ($request->hasFile('image')) {
                $data['image'] = $this->projectService->storeProjectImage($request->file('image'));
            }

            $project = $this->projectService->createProject($data);

            return $this->successResponse(new ProjectResource($project), 'Tạo project thành công', 201);
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

            return $this->successResponse(new ProjectResource($project), 'Lấy thông tin project thành công');
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
            $data = $request->validated();

            // Nếu có upload ảnh mới: upload ảnh mới và xóa ảnh cũ (nếu có)
            if ($request->hasFile('image')) {
                $projectCurrent = $this->projectService->getProjectById((int) $id);
                $data['image'] = $this->projectService->replaceProjectImage(
                    $request->file('image'),
                    $projectCurrent->image
                );
            }

            $project = $this->projectService->updateProject((int) $id, $data);

            return $this->successResponse(new ProjectResource($project), 'Cập nhật project thành công');
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

            // Trả list đã transform qua Resource
            $data = $projects->map(fn ($project) => (new ProjectResource($project))->resolve(request()))->all();

            return $this->successResponse($data, 'Lấy danh sách projects active thành công');
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

            // Trả list đã transform qua Resource
            $data = $projects->map(fn ($project) => (new ProjectResource($project))->resolve(request()))->all();

            return $this->successResponse($data, 'Lấy danh sách projects nổi bật thành công');
        } catch (\Exception $e) {
            return $this->errorResponse('Lỗi khi lấy danh sách projects nổi bật: ' . $e->getMessage(), 500);
        }
    }
}
