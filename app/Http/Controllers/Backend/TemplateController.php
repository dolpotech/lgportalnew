<?php

namespace App\Http\Controllers\Backend;

use App\Http\Controllers\Controller;
use App\Models\Template;
use App\Models\TemplateField;
use App\Services\Api\TemplateService;
use Illuminate\Http\Request;

class TemplateController extends Controller
{
    private $templateService;

    public function __construct(TemplateService $templateService)
    {
        $this->templateService = $templateService;
    }

    public function index()
    {
        $templates = $this->templateService->getAll();
        return view('Backend.template.index', compact("templates"));
    }

    public function createTemplate()
    {
        return view('Backend.template.partials.add');
    }

    public function storeTemplate(Request $request)
    {
        $templateId = Template::create([
           'name' => $request->get('template_name'),
           'insertion_type' => 'single'
        ]);
        $fields = $request->get('template_fields');
        $templateFields = [];

        foreach ($fields as $templateField) {

            $templateFields[] = [
                'template_id'   => $templateId->id,
                'name'          => $templateField['name'],
                'type'          => $templateField['type'],
                'default'       => "",
                'is_required'   => $templateField['is_required'] == true ? 1 : 0,
                'options'       => json_encode($templateField['options']),
            ];
        }

        TemplateField::insert($templateFields);
        return response()->json([
            'message' => 'Data added Successfully',
        ], 200);
//        return redirect()->route('getAllTemplates')->with('message','Data added Successfully');
    }

    public function editTemplate($id)
    {
        $template = Template::with('fields')->where('id' , $id)->get();
        return view('Backend.template.partials.edit', compact("template"));
    }

    public function updateTemplate(Request $request)
    {
        Template::where('id', $request->get('templateId'))->update([
            'name' => $request->get('template_name'),
            'insertion_type' => 'single'
        ]);
        $template = Template::with('fields')->where('id', $request->get('templateId'))->get();
        return response()->json([
            'message' => 'Data edited Successfully',
            'data' => $template,
        ], 200);
    }
    public function addTemplateField(Request $request)
    {
        $templateFields[] = [
            'template_id' => $request->get('template_id'),
            'name' => $request->get('field_name'),
            'type' => $request->get('data_type'),
            'default' => $request->get('default'),
            'is_required' => $request->get('is_required') ? 1 : 0,
            'options' => json_encode($request->get('options')),
        ];
        TemplateField::insert($templateFields);
        $template = Template::with('fields')->where('id', $request->get('template_id'))->get();
        return response()->json([
            'message' => 'Data added Successfully',
            'data' => $template,
        ], 200);
    }
    public function updateTemplateField(Request $request)
    {
        $templateField = TemplateField::where('id', $request->get('fieldId'))->update([
            'template_id' => $request->get('template_id'),
            'name' => $request->get('field_name'),
            'type' => $request->get('data_type'),
            'default' => $request->get('default'),
            'is_required' => $request->get('is_required') ? 1 : 0,
            'options' => json_encode($request->get('options')),
        ]);

        $template = Template::with('fields')->where('id', $request->get('template_id'))->get();
        return response()->json([
            'message' => 'Data added Successfully',
            'data' => $template,
        ], 200);
    }

    public function deleteTemplateField($id)
    {
        $templateField = TemplateField::where('id' , $id)->first();
        $templateField->delete();
        return response()->json([
            'message' => 'Data deleted Successfully',
        ], 200);
    }

}
