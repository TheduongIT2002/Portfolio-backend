<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Http\Requests\StoreContactRequest;
use App\Http\Resources\ContactResource;
use App\Services\ContactService;
use App\Traits\ApiResponse;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;

class ContactController extends Controller
{
    use ApiResponse;

    /**
     * @var ContactService
     */
    protected $contactService;

    /**
     * ContactController constructor.
     *
     * @param ContactService $contactService
     */
    public function __construct(ContactService $contactService)
    {
        $this->contactService = $contactService;
    }

    /**
     * API lưu thông tin contact từ form
     *
     * @param StoreContactRequest $request
     * @return JsonResponse
     */
    public function store(StoreContactRequest $request): JsonResponse
    {
        try {
            $contact = $this->contactService->createContact($request->validated());

            return $this->successResponse(
                new ContactResource($contact),
                'Gửi thông tin liên hệ thành công',
                201
            );
        } catch (\Exception $e) {
            return $this->errorResponse(
                'Lỗi khi gửi thông tin liên hệ: ' . $e->getMessage(),
                500
            );
        }
    }

    /**
     * (Dành cho admin) Lấy danh sách contacts với phân trang
     *
     * @param Request $request
     * @return JsonResponse
     */
    public function index(Request $request): JsonResponse
    {
        try {
            $perPage = (int) $request->get('per_page', 15);
            $contacts = $this->contactService->getAllContacts($perPage);
            /** @var \Illuminate\Pagination\LengthAwarePaginator $contacts */

            $contacts->setCollection(
                $contacts->getCollection()->map(
                    fn ($contact) => (new ContactResource($contact))->resolve($request)
                )
            );

            return $this->successResponse($contacts, 'Lấy danh sách liên hệ thành công');
        } catch (\Exception $e) {
            return $this->errorResponse(
                'Lỗi khi lấy danh sách liên hệ: ' . $e->getMessage(),
                500
            );
        }
    }

    public function destroy(int $id): JsonResponse
    {
        try {
            $this->contactService->delete($id);
            return $this->successResponse(null, 'Xóa liên hệ thành công');
        } catch (\Exception $e) {
            return $this->errorResponse('Lỗi khi xóa liên hệ: ' . $e->getMessage(), 500);
        }
    }

    public function updateStatus(int $id): JsonResponse
    {
        try {
            $this->contactService->updateStatus($id, request()->status);
            return $this->successResponse(null, 'Cập nhật trạng thái liên hệ thành công');
        } catch (\Exception $e) {
            return $this->errorResponse('Lỗi khi cập nhật trạng thái liên hệ: ' . $e->getMessage(), 500);
        }
    }

}
