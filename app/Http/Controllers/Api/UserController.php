<?php

namespace App\Http\Controllers\Api;

use App\HelperClasses\Traits\ApiResponse;
use App\Http\Controllers\Controller;
use App\Http\Requests\Api\Users\CreateMinistryOfficeRequest;
use App\Http\Requests\Api\Users\StoreLgUserRequest;
use App\Http\Requests\Api\Users\StoreMinistryOfficeUserRequest;
use App\Http\Requests\Api\Users\StoreMinistryUserRequest;
use App\Http\Requests\Api\Users\UpdateLgUserRequest;
use App\Http\Requests\Api\Users\UpdateMinistryOfficeRequest;
use App\Http\Requests\Api\Users\UpdateMinistryOfficeUserRequest;
use App\Http\Requests\Api\Users\UpdateMinistryUserRequest;
use App\Services\Api\UserService;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;


class UserController extends Controller
{
    use ApiResponse;

    protected $userService;

    public function __construct(UserService $userService)
    {
        $this->userService = $userService;
    }


    /**
     * Create Ministry User
     *
     * @param StoreMinistryUserRequest $request
     * @return JsonResponse
     */
    public function createMinistryUser(StoreMinistryUserRequest $request): JsonResponse
    {
        $this->userService->createMinisterUser(
            (string) $request->get('first_name'),
            (string) $request->get('address'),
            (string) $request->get('email'),
            (string) $request->get('password'),
            (string) $request->get('user_type'),
            (int) $request->get('role_id'),
            (int) $request->get('status'),
            $request->get('ministry_id'),
            $request->get('office_id'),
//            (int) $request->get('ministry_department_id'),
            $request->get('phone_no')
        );

        return $this->sendApiSuccessResponse([], 'Ministry User created successfully');
    }

    /**
     * Update Ministry User
     *
     * @param UpdateMinistryUserRequest $request
     * @return JsonResponse
     */
    public function updateMinistryUser(UpdateMinistryUserRequest $request): JsonResponse
    {
        $this->userService->updateMinisterUser(
            (string) $request->get('user_id'),
            (string) $request->get('first_name'),
            (string) $request->get('address'),
            (string) $request->get('email'),
            (string) $request->get('password'),
            (string) $request->get('user_type'),
            (int) $request->get('role_id'),
            (int) $request->get('status'),
            (int) $request->get('ministry_id'),
            $request->get('office_id'),
            (string) $request->get('phone_no')
        );

        return $this->sendApiSuccessResponse([], 'Ministry User updated successfully');
    }


    /**
     * Get Ministry Users
     *
     * @param Request $request
     * @return JsonResponse
     */
    public function getMinistryUsers(Request $request): JsonResponse
    {
        $data = $this->userService->getMinistryUsers(
            (string) $request->get('name'),
            (string) $request->get('email'),
            (string) $request->get('status'),
            (string) $request->get('pagination_no')
        );

        return $this->sendApiSuccessResponse($data, 'Ministries retrieved successfully');
    }



    /**
     * Get Ministry Roles
     *
     * @param Request $request
     * @return JsonResponse
     */
    public function getMinistryRoles(Request $request): JsonResponse
    {
        $data = $this->userService->getMinistryRoles();

        return $this->sendApiSuccessResponse($data, 'Ministry roles fetched successfully');
    }


    /**
     * Get Lg Officers
     *
     * @param Request $request
     * @return JsonResponse
     */
    public function getLgOfficers(Request $request)
    {
        $data = $this->userService->getLgOfficers(
            (string) $request->get('province_id'),
            (string) $request->get('district_id'),
            (string) $request->get('name'),
            (string) $request->get('email'),
            (string) $request->get('status'),
            (string) $request->get('pagination_no')
        );

        return $this->sendApiSuccessResponse($data, 'Lg officers fetched successfully');
    }


    /**
     * Get Ministry Officers
     *
     * @param Request $request
     * @return JsonResponse
     */
    public function getMinistryOfficers(Request $request): JsonResponse
    {
        $data = $this->userService->getMinistryOfficers((string) $request->get('ministry_id'));

        return $this->sendApiSuccessResponse($data, 'Ministry officers fetched successfully');
    }



    /**
     * Get Lg Users
     *
     * @param Request $request
     * @return JsonResponse
     */
    public function getLgUsers(Request $request): JsonResponse
    {
        $data = $this->userService->getLgUsers(
            (string) $request->get('name'),
            (string) $request->get('email'),
            (string) $request->get('status'),
            (string) $request->get('pagination_no')
        );

        return $this->sendApiSuccessResponse($data, 'Local government retrieved successfully');
    }



    /**
     * Create Local Government User
     *
     * @param StoreLgUserRequest $request
     * @return JsonResponse
     */
    public function createLgUser(StoreLgUserRequest $request): JsonResponse
    {
        $this->userService->createLgUser(
            (string) $request->get('first_name'),
            (string) $request->get('address'),
            (string) $request->get('email'),
            (string) $request->get('password'),
            (string) $request->get('user_type'),
            (int) $request->get('role_id'),
            (int) $request->get('status'),
            $request->get('lg_id'),
            $request->get('phone_no')
        );

        return $this->sendApiSuccessResponse([], 'Lg User created successfully');
    }


    /**
     * Update Local Government User
     *
     * @param UpdateLgUserRequest $request
     * @return JsonResponse
     */
    public function updateLgUser(UpdateLgUserRequest $request): JsonResponse
    {
        $this->userService->updateLgUser(
            (string) $request->get('user_id'),
            (string) $request->get('first_name'),
            (string) $request->get('address'),
            (string) $request->get('email'),
            (string) $request->get('password'),
            (string) $request->get('user_type'),
            (int) $request->get('role_id'),
            (int) $request->get('status'),
            (int) $request->get('lg_id'),
            (string) $request->get('phone_no')
        );

        return $this->sendApiSuccessResponse([], 'Lg User updated successfully');
    }


    /**
     * Get Local Government Roles
     *
     * @param Request $request
     * @return JsonResponse
     */
    public function getLgRoles(Request $request): JsonResponse
    {
        $data = $this->userService->getLgRoles();

        return $this->sendApiSuccessResponse($data, 'local government roles retrieved successfully');
    }

    /**
     * Create Ministry Office User
     *
     * @param StoreMinistryOfficeUserRequest $request
     * @return JsonResponse
     */
    public function createMinistryOfficeUser(StoreMinistryOfficeUserRequest $request): JsonResponse
    {
        $this->userService->createMinistryOfficeUser(
            (string) $request->get('first_name'),
            (string) $request->get('address'),
            (string) $request->get('email'),
            (string) $request->get('password'),
            (string) $request->get('user_type'),
            (int) $request->get('role_id'),
            (int) $request->get('status'),
            $request->get('office_id'),
            $request->get('phone_no')
        );

        return $this->sendApiSuccessResponse([], 'Ministry Office User created successfully');
    }


    /**
     * Update Ministry Office User
     *
     * @param UpdateMinistryOfficeUserRequest $request
     * @return JsonResponse
     */
    public function updateMinistryOfficeUser(UpdateMinistryOfficeUserRequest $request): JsonResponse
    {
        $this->userService->updateMinistryOfficeUser(
            (string) $request->get('user_id'),
            (string) $request->get('first_name'),
            (string) $request->get('address'),
            (string) $request->get('email'),
            (string) $request->get('password'),
            (string) $request->get('user_type'),
            (int) $request->get('role_id'),
            (int) $request->get('status'),
            (int) $request->get('office_id'),
            (string) $request->get('phone_no')
        );

        return $this->sendApiSuccessResponse([], 'Ministry Office User updated successfully');
    }


    /**
     * Get Ministry Office Roles
     *
     * @param Request $request
     * @return JsonResponse
     */
    public function getMinistryOfficeRoles(Request $request): JsonResponse
    {
        $data = $this->userService->getMinistryOfficeRoles();

        return $this->sendApiSuccessResponse($data, 'Ministry Office roles retrieved successfully');
    }


    /**
     * Get Ministry Office Users
     *
     * @param Request $request
     * @return JsonResponse
     */
    public function getMinistryOfficeUsers(Request $request): JsonResponse
    {
        $data = $this->userService->getMinistryOfficeUsers(
            (string) $request->get('name'),
            (string) $request->get('email'),
            (string) $request->get('status'),
            (string) $request->get('pagination_no')
        );

        return $this->sendApiSuccessResponse($data, 'Ministry Offices retrieved successfully');
    }


    /**
     * Create Ministry Office User
     *
     * @param CreateMinistryOfficeRequest $request
     * @return JsonResponse
     */
    public function createMinistryOffice(CreateMinistryOfficeRequest $request): JsonResponse
    {
        $this->userService->createMinistryOffice(
            (string) $request->get('name'),
            (string) $request->get('name_en'),
            (string) $request->get('email'),
            $request->get('phone_no'),
            (string) $request->get('address'),
            (string) $request->get('status')
        );

        return $this->sendApiSuccessResponse([], 'Ministry Office User created successfully');
    }

    /**
     * Update Ministry Office User
     *
     * @param UpdateMinistryOfficeRequest $request
     * @return JsonResponse
     */
    public function updateMinistryOffice(UpdateMinistryOfficeRequest $request): JsonResponse
    {
        $this->userService->updateMinistryOffice(
            (int) $request->get('mo_id'),
            (string) $request->get('name'),
            (string) $request->get('name_en'),
            (string) $request->get('email'),
            (string) $request->get('address'),
            $request->get('phone_no'),
            (string) $request->get('status')

        );

        return $this->sendApiSuccessResponse([], 'Ministry Office User updated successfully');
    }

    /**
     * List Ministry Offices
     *
     * @return mixed
     */
    public function listMinistryOffices()
    {
        $ministryOfficeLists = $this->userService->listMinistryOffices();

        if (!$ministryOfficeLists)
        {
            return $this->sendApiErrorResponse([], 'Empty Ministry Offices');
        }

        return $this->sendApiSuccessResponse($ministryOfficeLists,'Ministry Office User List');
    }

}
