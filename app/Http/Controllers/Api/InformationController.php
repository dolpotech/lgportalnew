<?php

namespace App\Http\Controllers\Api;

use App\HelperClasses\Traits\ApiResponse;
use App\HelperClasses\Traits\AuthHelper;
use App\Http\Controllers\Controller;
use App\Http\Requests\Api\InformationCollection\CreateNewInformationCollectionRequest;
use App\Http\Requests\Api\InformationCollection\SetInformationApprovedRequest;
use App\Http\Requests\Api\InformationCollection\SetInformationCompletedRequest;
use App\Http\Requests\Api\InformationCollection\StartProcessingInformationRequest;
use App\Http\Requests\Api\InformationCollection\UpdateInformationCollectionRequest;
use App\Services\Api\InformationCollectionService;
use App\Services\Api\NotificationService;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\File;
use Illuminate\Support\Facades\Response;


class InformationController extends Controller
{
    use ApiResponse, AuthHelper;

    private $informationService;

    public function __construct(InformationCollectionService $informationService)
    {
        $this->informationService = $informationService;
    }


    /**
     * Display a listing of the resource.
     *
     * @param CreateNewInformationCollectionRequest $request
     * @return JsonResponse
     */
    public function createNewCollection(CreateNewInformationCollectionRequest $request): JsonResponse
    {
        $information = $this->informationService->createNew(
            (string) $request->get('title'),
            (string) $request->get('type'),
            (string) $request->get('description'),
            (int) $request->get('template_id'),
            $request->file('main_doc'),
            $request->file('supporting_doc'),
            (array) $request->get('document_type'),
            (array) $request->get('ministry_ids'),
            (array) $request->get('lg_ids'),
            (array) $request->get('ministry_office_ids'),
            (string) isValidDate($request->get('start_date')) ? $request->get('start_date') : '',
            (string) isValidDate($request->get('submission_date')) ? $request->get('submission_date') : '',
            (string) $request->get('priority')
        );

        return $this->sendApiSuccessResponse($information, 'New Information Collection Added Successfully');
    }

    /**
     * Update a listing of the resource.
     *
     * @param UpdateInformationCollectionRequest $request
     * @return JsonResponse
     */
    public function updateNewCollection(UpdateInformationCollectionRequest $request): JsonResponse
    {
        $information = $this->informationService->updateOld(
            (int) $request->get('information_id'),
            (string) $request->get('title'),
            (string) $request->get('type'),
            (string) $request->get('description'),
            (int) $request->get('template_id'),
            $request->file('main_doc'),
            $request->file('supporting_doc'),
            (array) $request->get('document_type'),
            (string) $request->get('start_date'),
            (string) $request->get('submission_date'),
            (string) $request->get('priority')
        );

        return $this->sendApiSuccessResponse($information, 'New Information Collection Added Successfully');
    }


    /**
     * Get Information List For Ministry Admin
     *
     * @param Request $request
     * @return JsonResponse
     */
    public function getInformationForMinistryAdmin(Request $request): JsonResponse
    {
        $information = $this->informationService->getInformationForMinistryAdmin();

        if ($information->count() == 0){
            return $this->sendApiSuccessResponse($information, 'Information list is Empty');
        }

        return $this->sendApiSuccessResponse($information, 'Processing Information retrieved successfully');
    }

    /**
     * Get Information Detail For Ministry Admin
     *
     * @param Request $request
     * @return JsonResponse
     */
    public function getInformationDetailForMinistryAdmin(Request $request): JsonResponse
    {
        $data = $this->informationService->getInformationDetailForMinistryAdmin((int) $request->get('information_id'));
        if (!$data){
            return $this->sendApiSuccessResponse($data, 'Information detail is Empty');
        }
        return $this->sendApiSuccessResponse($data, 'Information detail retrieved successfully');
    }

    /**
     * Get Assigned User Information list For Ministry Admin
     *
     * @param Request $request
     * @return JsonResponse
     */
    public function getAssignedUserInformationListForMinistryAdmin(Request $request): JsonResponse
    {
        $data = $this->informationService->fetchAssignedUserInformationListForMinistryAdmin((int) $request->get('information_id'));
        if (!$data){
            return $this->sendApiSuccessResponse($data, 'Information list is Empty');
        }
        return $this->sendApiSuccessResponse($data, 'Assigned User Information List retrieved successfully');
    }


    /**
     * Get Assigned User Information Detail For Ministry Admin
     *
     * @param Request $request
     * @return JsonResponse
     */
    public function getAssignedUserInformationDetailForMinistryAdmin(Request $request): JsonResponse
    {
        $data = $this->informationService->fetchAssignedUserInformationDetailForMinistryAdmin((int) $request->get('info_receiver_id'));
        if (!$data){
            return $this->sendApiSuccessResponse($data, 'Information detail is Empty');
        }
        return $this->sendApiSuccessResponse($data, 'Assigned User Information detail retrieved successfully');
    }

    /**
     * Get Total Information Completed For Ministry Admin
     *
     * @return mixed
     */
    public function getTotalInformationForMinistryAdmin()
    {
        $totalUser = $this->informationService->totalInformationForMinistryAdmin();

        return $this->sendApiSuccessResponse($totalUser, 'Total information For Ministry Admin');
    }

    /**
     * Get Information List For Ministry Admin Office CAO
     *
     * @param Request $request
     * @return JsonResponse
     */
    public function getInformationForMinistry(Request $request): JsonResponse
    {
        $information = $this->informationService->getInformationForMinistry();
        if (!$information){
            return $this->sendApiSuccessResponse($information, 'Information list is Empty');
        }
        return $this->sendApiSuccessResponse($information, 'Processing Information retrieved successfully');
    }

    /**
     * Get Information Detail For Ministry Admin/Officer/CAO
     *
     * @param Request $request
     * @return JsonResponse
     */
    public function getInformationDetailForMinistry(Request $request): JsonResponse
    {
        $data = $this->informationService->getInformationDetailForMinistry((int) $request->get('information_id'));
        if (!$data){
            return $this->sendApiSuccessResponse($data, 'Information detail is Empty');
        }
        return $this->sendApiSuccessResponse($data, 'Information detail retrieved successfully');
    }

    /**
     * Get Information collection Detail of Template or Documents For Ministry Admin/Officer/CAO
     *
     * @param Request $request
     * @return JsonResponse
     */
    public function getInformationCollectionDetailForMinistry(Request $request): JsonResponse
    {
        $data = $this->informationService->getInformationCollectionDetailForMinistry((int) $request->get('info_receiver_id'));
        if (!$data){
            return $this->sendApiSuccessResponse($data, 'Information detail is Empty');
        }
        return $this->sendApiSuccessResponse($data, 'Information detail retrieved successfully');
    }

    /**
     * Get Information List For Lg Admin
     *
     * @param Request $request
     * @return JsonResponse
     */
    public function getInformationForLg(Request $request): JsonResponse
    {
        $information = $this->informationService->getInformationForLg();

        if ($information->count() == 0)
        {
            return $this->sendApiSuccessResponse([],'LG Information is empty');
        }

        return $this->sendApiSuccessResponse($information, 'LG Information retrieved successfully');
    }

    /**
     * Get Information Detail For Lg
     *
     * @param Request $request
     * @return JsonResponse
     */
    public function getInformationDetailForLg(Request $request): JsonResponse
    {
        $data = $this->informationService->getInformationDetailForLg((int) $request->get('information_id'));
        if (!$data){
            return $this->sendApiSuccessResponse($data, 'Information detail is Empty');
        }
        return $this->sendApiSuccessResponse($data, 'Information detail retrieved successfully');
    }


    /**
     * Get Information collection Detail of Template or Documents For Lg
     *
     * @param Request $request
     * @return JsonResponse
     */
    public function getInformationCollectionDetailForLg(Request $request): JsonResponse
    {
        $data = $this->informationService->getInformationCollectionDetailForLg((int) $request->get('info_receiver_id'));

        if (!$data){
            return $this->sendApiSuccessResponse($data, 'Information detail is Empty');
        }
        return $this->sendApiSuccessResponse($data, 'Information detail retrieved successfully');
    }

    /**
     * Get Total Information Completed For Lg Admin
     *
     * @return mixed
     */
    public function getTotalInformationForLgAdmin()
    {
        $totalUser = $this->informationService->totalInformationForLgAdmin();

        return $this->sendApiSuccessResponse($totalUser, 'Total information For Lg Admin');
    }

    /**
     * Get Information List For Ministry Office
     *
     * @param Request $request
     * @return JsonResponse
     */
    public function getInformationForMinistryOffice(Request $request): JsonResponse
    {
        $information = $this->informationService->getInformationForMinistryOffice();
        if (!$information) {
            return $this->sendApiSuccessResponse($information, 'Ministry Office Information List is Empty');
        }
        return $this->sendApiSuccessResponse($information, 'Ministry Office Information retrieved successfully');
    }

    /**
     * Get Information Detail For Ministry Office
     *
     * @param Request $request
     * @return JsonResponse
     */
    public function getInformationDetailForMinistryOffice(Request $request): JsonResponse
    {
        $data = $this->informationService->getInformationDetailForMinistryOffice((int) $request->get('information_id'));
        if (!$data){
            return $this->sendApiSuccessResponse($data, 'Information detail is Empty');
        }
        return $this->sendApiSuccessResponse($data, 'Information detail retrieved successfully');
    }

    /**
     * Get Information collection Detail of Template or Documents For Ministry Office
     *
     * @param Request $request
     * @return JsonResponse
     */
    public function getInformationCollectionDetailForMinistryOffice(Request $request): JsonResponse
    {
        $data = $this->informationService->getInformationCollectionDetailForMinistryOffice((int) $request->get('info_receiver_id'));
        if (!$data){
            return $this->sendApiSuccessResponse($data, 'Information detail is Empty');
        }
        return $this->sendApiSuccessResponse($data, 'Information detail retrieved successfully');
    }

    /**
     * Get Total Information Completed For Ministry Office Admin
     *
     * @return mixed
     */
    public function getTotalInformationForMinistryOfficeAdmin()
    {
        $totalUser = $this->informationService->totalInformationForMinistryOfficeAdmin();

        return $this->sendApiSuccessResponse($totalUser, 'Total information For Ministry Office Admin');
    }

    /**
     * Start Processing
     *
     * @param StartProcessingInformationRequest $request
     * @return JsonResponse
     */
    public function startProcessingInformationByLgAdmin(StartProcessingInformationRequest $request): JsonResponse
    {
        $this->informationService->startProcessingByLgAdmin($request->get('information_id'));

        return $this->sendApiSuccessResponse([], 'Information processing started successfully');
    }


    /**
     * Set Information Completed
     *
     * @param SetInformationCompletedRequest $request
     * @return JsonResponse
     */
    public function setInformationCompletedByCao(SetInformationCompletedRequest  $request)
    {
        $this->informationService->setInformationCompleted((int) $request->get('info_receiver_id'));

        return $this->sendApiSuccessResponse([], 'Information completed successfully');
    }


    /**
     * Set Information Approved
     *
     * @param SetInformationApprovedRequest $request
     * @return mixed
     */
    public function setInformationApprovedByCao(SetInformationApprovedRequest $request)
    {
        $this->informationService->setInformationApproved((int) $request->get('info_receiver_id'));

        return $this->sendApiSuccessResponse([], 'Information approved successfully');
    }


    /**
     * Get main document file
     *
     * @return mixed
     */
    public function getMainDocumentForInformation($informationId)
    {
        $information = $this->informationService->getInformationById((int) $informationId);


        if (!$information) {
            abort(404);
        }

        $path = storage_path('app').DIRECTORY_SEPARATOR.$information->main_doc_path;

        if (!File::exists($path))  {
            abort(404);
        }

        $content_types = $this->checkContentType($information->main_doc_type);


        if (isset($content_types))
        {
            return Response::make(File::get($path), 200, [
                'Content-Type' => $content_types
            ]);
        }else{
            return Response::make(File::get($path));
        }

    }


    /**
     * Get supporting document file
     *
     * @return mixed
     */
    public function getSupportingDocumentForInformation($informationId)
    {
        $information = $this->informationService->getInformationById((int) $informationId);

        if (!$information) {
            abort(404);
        }

        $path = storage_path('app').DIRECTORY_SEPARATOR.$information->supporting_doc_path;

        if (!File::exists($path))  {
            abort(404);
        }

        $content_types = $this->checkContentType($information->supporting_doc_type);

        if (isset($content_types))
        {
            return Response::make(File::get($path), 200, [
                'Content-Type' => $content_types
            ]);
        }else{
            return Response::make(File::get($path));
        }
    }


    /**
     * Get Information Collection Report For Ministry
     *
     * @return mixed
     */
    public function getInformationCollectionReportForMinistry()
    {
        $information = $this->informationService->getInformationCollectionReportForMinistry();

        if (!$information){
            return $this->sendApiErrorResponse([], 'Information Collection Report is Empty');
        }
        return $this->sendApiSuccessResponse($information, 'Information Collection Report Fetched Successfully');
    }


    /**
     * Download main document file
     *
     * @return mixed
     */
    public function downloadMainDocumentForInformation($informationId)
    {
        $information = $this->informationService->downloadInformationById((int) $informationId);


        if (!$information) {
            abort(404);
        }

        $path = storage_path('app').DIRECTORY_SEPARATOR.$information->main_doc_path;

        if (!File::exists($path))  {
            abort(404);
        }

        return Response::download($path);
    }

    /**
     * Download supporting document file
     *
     * @return mixed
     */
    public function downloadSupportingDocumentForInformation($informationId)
    {
        $information = $this->informationService->downloadInformationById((int) $informationId);

        if (!$information) {
            abort(404);
        }

        $path = storage_path('app').DIRECTORY_SEPARATOR.$information->supporting_doc_path;

        if (!File::exists($path))  {
            abort(404);
        }

        return Response::download($path);
    }

    /**
     * Check Content Type of files
     * @param string $fileType
     * @return mixed
     */
    public function checkContentType(string $fileType)
    {
        if($fileType=='pdf'){
            $content_types='application/pdf';
        }elseif ($fileType=='doc') {
            $content_types='application/msword';
        }elseif ($fileType=='docx') {
            $content_types='application/vnd.openxmlformats-officedocument.wordprocessingml.document';
        }elseif ($fileType=='xls') {
            $content_types='application/vnd.ms-excel';
        }elseif ($fileType=='xlsx') {
            $content_types='application/vnd.openxmlformats-officedocument.spreadsheetml.sheet';
        }elseif ($fileType=='txt') {
            $content_types='application/octet-stream';
        }elseif ($fileType=='jpeg') {
            $content_types='image/jpeg';
        }elseif ($fileType=='png' || $fileType=='PNG') {
            $content_types='image/png';
        }elseif ($fileType=='jpg') {
            $content_types='image/jpg';
        }

        return isset($content_types) ? $content_types ?? '' : null;
    }

    /**
     * Get Information Collection
     *
     * @return mixed
     */
    public function getInformationCollection(Request $request)
    {
        $information = $this->informationService->getInformationCollection(
            (string) $request->get('type'),
            (string) $request->get('title'),
            (string) $request->get('status'),
            (string) $request->get('pagination_no')
        );

        if ($information->count() == 0)
        {
            return $this->sendApiSuccessResponse([],'Information Collection is empty','');
        }

        return $this->sendApiSuccessResponse($information,'Information Collection retrieved successfully');
    }

    /**
     * get Ministry Office Information Create on select ministry
     *
     * @return mixed
     */
    public function getMinistryOfficeInformation(Request $request)
    {
        $ministryOffices = $this->informationService->getMinistryOfficeInformation((int) $request->get('ministry_id'));

        if ($ministryOffices->count() == 0)
        {
           return $this->sendApiSuccessResponse([],'Ministry Office is empty','');
        }

        return $this->sendApiSuccessResponse($ministryOffices,'Ministry Office fetched successfully');

    }

}
