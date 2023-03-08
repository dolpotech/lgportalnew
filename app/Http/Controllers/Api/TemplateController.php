<?php

namespace App\Http\Controllers\Api;

use App\HelperClasses\Traits\ApiResponse;
use App\Http\Controllers\Controller;
use App\Http\Requests\Api\Template\StoreTemplateRequest;
use App\Http\Requests\Api\Template\UpdateTemplateRequest;
use App\Services\Api\TemplateService;
use Illuminate\Http\JsonResponse;


class TemplateController extends Controller
{
    use ApiResponse;

    private $templateService;

    public function __construct(TemplateService $templateService)
    {
        $this->templateService = $templateService;
    }


    /**
     * Display a listing of the resource.
     *
     * @return JsonResponse
     */
    public function getAllTemplates(): JsonResponse
    {
        $templates = $this->templateService->getAll();

        return $this->sendApiSuccessResponse($templates, 'Templates fetched Successfully');
    }


    /**
     * Store a newly created resource in storage.
     *
     * @param StoreTemplateRequest $request
     * @return JsonResponse
     */
    public function storeTemplate(StoreTemplateRequest $request): JsonResponse
    {
        $template = $this->templateService->createTemplate(
            (string) $request->get('name'),
            (string) $request->get('insertion_type'),
            (array) $request->get('fields')
        );

        return $this->sendApiSuccessResponse($template, 'Template created successfully');
    }


    /**
     * Update Template
     *
     * @param UpdateTemplateRequest $request
     * @return JsonResponse
     */
    public function updateTemplate(UpdateTemplateRequest $request): JsonResponse
    {
        $this->templateService->updateTemplate(
            (int) $request->get('template_id'),
            (string) $request->get('template_name'),
            (string) $request->get('insertion_type')
        );

        /*foreach ($request->template_field as $key => $template) {
            if (in_array($template['type'], ['select', 'checkbox', 'radio'])) {
                $options = json_encode($template['options'][0]);
            } else {
                $options = isset($template['options']) ? $template['options'] : '';
            }
            $templateField = TemplateField::find($template['id']);
            if ($templateField != '') {
                $templateField->update([
                    'template_id' => 1,
                    'name' => isset($template['name']) ? $template['name'] : '',
                    'type' => isset($template['type']) ? $template['type'] : '',
                    'default' => isset($template['default']) ? $template['default'] : '',
                    'is_required' => isset($template['is_required']) ? $template['is_required'] : '',
                    'options' => $options
                ]);
            }
        }*/

        return $this->sendApiSuccessResponse([], 'Template Updated Successfully');
    }


}
