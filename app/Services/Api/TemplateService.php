<?php


namespace App\Services\Api;


use App\Models\Template;
use App\Models\TemplateField;

class TemplateService
{


    /**
     * Get All Templates
     *
     * @return mixed
     */
    public function getAll()
    {
        return Template::all();
    }


    /**
     * Create Template
     *
     * @param string $templateName
     * @param string $insertionType
     * @param array $fields
     * @return mixed
     */
    public function createTemplate(string $templateName, string $insertionType, array $fields)
    {
        $template = Template::create([
            'name'              => $templateName,
            'insertion_type'    => $insertionType
        ]);

        $templateFields = [];

        foreach ($fields as $templateField) {

            $options = in_array($templateField['type'], getFieldOptionTypes()) ? ($templateField['options'] ?? []) : [];

            $templateFields[] = [
                'template_id'   => $template->id,
                'name'          => $templateField['name'],
                'type'          => $templateField['type'],
                'default'       => $templateField['default'] ?? '',
                'is_required'   => $templateField['is_required'] ?? 0,
                'options'       => json_encode($options),
            ];
        }

        TemplateField::insert($templateFields);

        return $template;
    }


    /**
     * Update Template
     *
     * @return mixed
     */
    public function updateTemplate(int $templateId, string $templateName, string $insertionType)
    {
        return Template::where('id', $templateId)->update([
            'name'              => $templateName,
            'insertion_type'    => $insertionType
        ]);
    }

}
