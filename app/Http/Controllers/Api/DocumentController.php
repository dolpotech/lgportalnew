<?php

namespace App\Http\Controllers\Api;

use App\HelperClasses\Traits\ApiResponse;
use App\Http\Controllers\Controller;
use App\Http\Requests\Api\Document\CreateDocumentCommentRequestForLg;
use App\Http\Requests\Api\Document\CreateDocumentCommentRequestForMinistry;
use App\Http\Requests\Api\Document\CreateDocumentCommentRequestForMo;
use App\Http\Requests\Api\Document\CreateDocumentRequestForMinistry;
use App\Http\Requests\Api\Document\CreateDocumentRequestForMO;
use App\Http\Requests\Api\Document\CreateUpdateTemplateQuestionAnswerRequestForLG;
use App\Http\Requests\Api\Document\CreateUpdateTemplateQuestionAnswerRequestForMinistry;
use App\Http\Requests\Api\Document\CreateUpdateTemplateQuestionAnswerRequestForMO;
use App\Http\Requests\Api\Document\ReplyDocumentCommentRequestForLg;
use App\Http\Requests\Api\Document\ReplyDocumentCommentRequestForMinistry;
use App\Http\Requests\Api\Document\ReplyDocumentCommentRequestForMo;
use App\Http\Requests\Api\Document\UpdateDocumentAnswerForDocumentRequest;
use App\Http\Requests\Api\Document\UpdateDocumentForDocumentRequestForLG;
use App\Http\Requests\Api\Document\UpdateDocumentForDocumentRequestForMinistry;
use App\Http\Requests\Api\Document\UpdateDocumentForDocumentRequestForMO;
use App\Http\Requests\Api\Document\CreateDocumentRequestForLG;
use App\Services\Api\DocumentService;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\File;
use Illuminate\Support\Facades\Response;


class DocumentController extends Controller
{
    use ApiResponse;

    private $documentService;

    public function __construct(DocumentService $documentService)
    {
        $this->documentService = $documentService;
    }


    /**
     * Update Document Answer
     *
     * @param UpdateDocumentAnswerForDocumentRequest $request
     * @return JsonResponse
     */
    public function updateDocumentAnswerByLgOfficer(UpdateDocumentAnswerForDocumentRequest $request): JsonResponse
    {
        $document = $this->documentService->updateDocumentAnswer(
            (int) $request->get('document_id'),
            (string) $request->get('answer')
        );

        return $this->sendApiSuccessResponse($document, 'Document updated successfully');
    }

    /**
     * Update Document
     *
     * @param UpdateDocumentForDocumentRequestForLG $request
     * @return JsonResponse
     */
    public function updateDocumentByLgOfficer(UpdateDocumentForDocumentRequestForLG $request): JsonResponse
    {
        $document = $this->documentService->updateDocument(
            (int) $request->get('info_receiver_id'),
            $request->file('main_doc'),
            $request->file('supporting_doc')
        );

        return $this->sendApiSuccessResponse($document, 'Document updated successfully');
    }

    /**
     * Get Comments of Document
     *
     * @param Request $request
     * @return JsonResponse
     */
    public function getDocumentCommentsForLg(Request $request): JsonResponse
    {
        $data = $this->documentService->getDocumentComments((int) $request->get('document_id'));

        return $this->sendApiSuccessResponse($data, 'Document Field Comments retrieved successfully');
    }


    /**
     * Create Comment On Document Field
     *
     * @param CreateDocumentCommentRequestForLg $request
     * @return JsonResponse
     */
    public function createCommentOnDocumentForLg(CreateDocumentCommentRequestForLg $request): JsonResponse
    {
        $comment = $this->documentService->createDocumentComment(
            (int) $request->get('document_id'),
            (string) $request->get('message')
        );

        return $this->sendApiSuccessResponse($comment, 'Message sent successfully');
    }


    /**
     * Reply Comment On Document By LG
     *
     * @param ReplyDocumentCommentRequestForLg $request
     * @return mixed
     */
    public function replyCommentOnDocument(ReplyDocumentCommentRequestForLg $request)
    {
        $this->documentService->replyDocumentComment(
            (int) $request->get('comment_id'),
            (string) $request->get('message')
        );

        return $this->sendApiSuccessResponse([], 'Document message replied successfully');
    }

    /**
     * Create Comment On Document Field
     *
     * @param CreateDocumentCommentRequestForMo $request
     * @return JsonResponse
     */
    public function createCommentOnDocumentForMo(CreateDocumentCommentRequestForMo $request): JsonResponse
    {
        $comment = $this->documentService->createDocumentComment(
            (int) $request->get('document_id'),
            (string) $request->get('message')
        );

        return $this->sendApiSuccessResponse($comment, 'Message sent successfully');
    }

    /**
     * Create Comment On Document Field By Ministry
     *
     * @param CreateDocumentCommentRequestForMinistry $request
     * @return JsonResponse
     */
    public function createCommentOnDocumentForMinistry(CreateDocumentCommentRequestForMinistry $request): JsonResponse
    {
        $comment = $this->documentService->createDocumentComment(
            (int) $request->get('document_id'),
            (string) $request->get('message')
        );

        return $this->sendApiSuccessResponse($comment, 'Message sent successfully');
    }

    /**
     * Reply Comment On Document By Ministry
     *
     * @param ReplyDocumentCommentRequestForMinistry $request
     * @return mixed
     */
    public function replyCommentOnDocumentForMinistry(ReplyDocumentCommentRequestForMinistry $request)
    {
        $this->documentService->replyDocumentComment(
            (int) $request->get('comment_id'),
            (string) $request->get('message')
        );

        return $this->sendApiSuccessResponse([], 'Document message replied successfully');
    }

    /**
     * Reply Comment On Document By Ministry Office
     *
     * @param ReplyDocumentCommentRequestForMo $request
     * @return mixed
     */
    public function replyCommentOnDocumentForMo(ReplyDocumentCommentRequestForMo $request)
    {
        $this->documentService->replyDocumentComment(
            (int) $request->get('comment_id'),
            (string) $request->get('message')
        );

        return $this->sendApiSuccessResponse([], 'Document message replied successfully');
    }

    /**
     * Create/Update Question Answer Document Ministry CAO/Officer
     *
     * @param CreateUpdateTemplateQuestionAnswerRequestForMinistry $request
     * @return JsonResponse
     */
    public function createQuestionAnswerByMinistryOfficer(CreateUpdateTemplateQuestionAnswerRequestForMinistry $request): JsonResponse
    {
        $document = $this->documentService->createUpdateQuestionAnswer(
            (int) $request->get('info_receiver_id'),
            (int) $request->get('field_id'),
            (string) $request->get('answer')
        );

        return $this->sendApiSuccessResponse($document, 'Template created successfully');
    }

    /**
     * Create/Update Question Answer Document Lg CAO/Officer
     *
     * @param CreateUpdateTemplateQuestionAnswerRequestForLG $request
     * @return JsonResponse
     */
    public function createQuestionAnswerByLgOfficer(CreateUpdateTemplateQuestionAnswerRequestForLG $request): JsonResponse
    {
        $document = $this->documentService->createUpdateQuestionAnswer(
            (int) $request->get('info_receiver_id'),
            (int) $request->get('field_id'),
            (string) $request->get('answer')
        );

        return $this->sendApiSuccessResponse($document, 'Template created successfully');
    }

    /**
     * Create Document By LG Officer
     *
     * @param CreateDocumentRequestForLG $request
     * @return JsonResponse
     */
    public function createDocumentByLgOfficer(CreateDocumentRequestForLG $request): JsonResponse
    {
        $document = $this->documentService->createDocumentType(
            (int) $request->get('info_receiver_id'),
            $request->file('main_doc'),
            $request->file('supporting_doc')
        );

        return $this->sendApiSuccessResponse($document, 'Document created successfully');
    }

    /**
     * Create/Update Question Answer Document MO CAO/Officer
     *
     * @param CreateUpdateTemplateQuestionAnswerRequestForMO $request
     * @return JsonResponse
     */
    public function createQuestionAnswerByMinistryOfficeOfficer(CreateUpdateTemplateQuestionAnswerRequestForMO $request): JsonResponse
    {
        $document = $this->documentService->createUpdateQuestionAnswer(
            (int) $request->get('info_receiver_id'),
            (int) $request->get('field_id'),
            (string) $request->get('answer')
        );

        return $this->sendApiSuccessResponse($document, 'Template created successfully');
    }

    /**
     * Create Question Answer By Ministry Office
     *
     * @param CreateDocumentRequestForMinistry $request
     * @return JsonResponse
     */
    public function createDocumentByMinistryOfficer(CreateDocumentRequestForMinistry $request): JsonResponse
    {
        $document = $this->documentService->createDocumentType(
            (int) $request->get('info_receiver_id'),
            $request->file('main_doc'),
            $request->file('supporting_doc')
        );

        return $this->sendApiSuccessResponse($document, 'Document created successfully');
    }

    /**
     * Update Document By Ministry Officer
     *
     * @param UpdateDocumentForDocumentRequestForMinistry $request
     * @return JsonResponse
     */
    public function updateDocumentByMinistryOfficer(UpdateDocumentForDocumentRequestForMinistry $request): JsonResponse
    {
        $document = $this->documentService->updateDocument(
            (int) $request->get('info_receiver_id'),
            $request->file('main_doc'),
            $request->file('supporting_doc')
        );

        return $this->sendApiSuccessResponse($document, 'Document updated successfully');
    }

    /**
     * Create Document By Ministry Office Officer
     *
     * @param CreateDocumentRequestForMO $request
     * @return JsonResponse
     */
    public function createDocumentByMoOfficer(CreateDocumentRequestForMO $request): JsonResponse
    {
        $document = $this->documentService->createDocumentType(
            (int) $request->get('info_receiver_id'),
            $request->file('main_doc'),
            $request->file('supporting_doc')
        );

        return $this->sendApiSuccessResponse($document, 'Document created successfully');
    }

    /**
     * Update Document By Ministry Officer
     *
     * @param UpdateDocumentForDocumentRequestForMO $request
     * @return JsonResponse
     */
    public function updateDocumentByMoOfficer(UpdateDocumentForDocumentRequestForMO $request): JsonResponse
    {
        $document = $this->documentService->updateDocument(
            (int) $request->get('info_receiver_id'),
            $request->file('main_doc'),
            $request->file('supporting_doc')
        );

        return $this->sendApiSuccessResponse($document, 'Document updated successfully');
    }


    /**
     * get main document file
     *
     * @return mixed
     */
    public function getMainDocumentForDocument($documentId)
    {
        $document = $this->documentService->getDocumentById((int) $documentId);

        if (!$document)
        {
            abort(400);
        }

        $path = public_path('app').DIRECTORY_SEPARATOR.$document->main_doc_path;

        if (!File::exists($path))
        {
            abort(400);
        }

        return Response::make(File::get($path));
    }

    /**
     * Get Document Supporting Path
     *
     * @return mixed
     */
    public function getSupportingDocumentForDocument($documentId)
    {
        $document = $this->documentService->getDocumentById((int) $documentId);

        if (!$document)
        {
            abort(400);
        }

        $path = public_path('app').DIRECTORY_SEPARATOR.$document->supporting_doc_path;

        if (!File::exists($path))
        {
            abort(400);
        }

        return Response::make(File::get($path));
    }

    /**
     * Download main document file
     *
     * @return mixed
     */
    public function downloadMainDocumentForDocument($documentId)
    {
        $document = $this->documentService->downloadInformationById((int) $documentId);


        if (!$document) {
            abort(404);
        }

        $path = storage_path('app').DIRECTORY_SEPARATOR.$document->main_doc_path;

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
    public function downloadSupportingDocumentForDocument($documentId)
    {
        $document = $this->documentService->downloadInformationById((int) $documentId);

        if (!$document) {
            abort(404);
        }

        $path = storage_path('app').DIRECTORY_SEPARATOR.$document->supporting_doc_path;

        if (!File::exists($path))  {
            abort(404);
        }

        return Response::download($path);
    }

}
