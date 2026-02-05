<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Http\Requests\UpdatePersonalInfoRequest;
use App\Http\Resources\PersonalInfoResource;
use App\Services\PersonalInfoService;
use App\Traits\ApiResponse;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;

class PersonalInfoController extends Controller
{
    use ApiResponse;

    /**
     * @var PersonalInfoService
     */
    protected $personalInfoService;

    public function __construct(PersonalInfoService $personalInfoService)
    {
        $this->personalInfoService = $personalInfoService;
    }

    /**
     * Public: Lấy thông tin cá nhân để hiển thị trên trang main page
     */
    public function show(): JsonResponse
    {
        try {
            $info = $this->personalInfoService->getPersonalInfo();

            if (!$info) {
                return $this->successResponse(null, 'Chưa có thông tin cá nhân');
            }

            return $this->successResponse(new PersonalInfoResource($info), 'Lấy thông tin cá nhân thành công');
        } catch (\Exception $e) {
            return $this->errorResponse('Lỗi khi lấy thông tin cá nhân: ' . $e->getMessage(), 500);
        }
    }

    /**
     * Admin: cập nhật thông tin cá nhân (và xử lý upload avatar, cv)
     */
    public function update(UpdatePersonalInfoRequest $request): JsonResponse
    {
        try {
            $data = $request->validated();

            $current = $this->personalInfoService->getPersonalInfo();

            // Xử lý upload avatar
            if ($request->hasFile('avatar')) {
                $data['avatar'] = $this->personalInfoService->storeAvatar(
                    $request->file('avatar'),
                    $current?->avatar
                );
            }

            // Xử lý upload CV
            if ($request->hasFile('cv_file')) {
                $data['cv_file'] = $this->personalInfoService->storeCvFile(
                    $request->file('cv_file'),
                    $current?->cv_file
                );
            }

            $info = $this->personalInfoService->upsertPersonalInfo($data);

            return $this->successResponse(new PersonalInfoResource($info), 'Cập nhật thông tin cá nhân thành công');
        } catch (\Exception $e) {
            return $this->errorResponse('Lỗi khi cập nhật thông tin cá nhân: ' . $e->getMessage(), 500);
        }
    }
}
