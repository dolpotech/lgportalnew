<?php

namespace Database\Seeders;

use App\Models\Template;
use App\Models\TemplateField;
use Illuminate\Database\Seeder;

class TemplateTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $templates = [
            [
                'name' => 'PERIODIC PLAN',
                'fields' => [
                    [
                        'name' => 'पालिकाको प्रोफाईल तयार भएको छ/छैन',
                        'type' => 'radio',
                        'is_required' => 1,
                        'options' => [
                            ['label' => 'छ', 'value' => 1],
                            ['label' => 'छैन', 'value' => 0]
                        ]
                    ],
                    [
                        'name' => 'पालिकाको आवधिक  योजना तयार भएको  छ/छैन /प्रक्रियामा रहेको',
                        'type' => 'radio',
                        'is_required' => 1,
                        'options' => [
                            ['label' => 'छ', 'value' => 1],
                            ['label' => 'छैन', 'value' => 0]
                        ]
                    ],
                    [
                        'name' => 'तयार नभएको भए यो वर्ष आबधिका विकास योजना तयार गर्न लक्ष्य भएको/ नभएको ',
                        'type' => 'radio',
                        'is_required' => 1,
                        'options' => [
                            ['label' => 'भएको', 'value' => 1],
                            ['label' => 'नभएको', 'value' => 0]
                        ]
                    ],
                    [
                        'name' => 'आबधिका विकास योजना तयार गर्ने लक्ष्य भए प्रविधिक र आर्थिक सहयोग चाहिने/ नचाहिने',
                        'type' => 'radio',
                        'is_required' => 1,
                        'options' => [
                            ['label' => 'चाहिने', 'value' => 1],
                            ['label' => 'नचाहिने', 'value' => 0]
                        ]
                    ],
                    [
                        'name' => 'शहरी विकास, भवन निर्माण, वस्ती विकास जस्ता क्षेत्रगत नीति/रणनीति  तथा मापदण्ड निर्माण भएका छन्/छैनन्',
                        'type' => 'radio',
                        'is_required' => 1,
                        'options' => [
                            ['label' => 'छन्', 'value' => 1],
                            ['label' => 'छैनन्', 'value' => 0]
                        ]
                    ],
                ]
            ],
            [
                'name' => 'MTEF',
                'fields' => [
                    [
                        'name' => 'मध्यमकालीन खर्च संरचना तयार भएको/ नभएको',
                        'type' => 'radio',
                        'is_required' => 1,
                        'options' => [
                            ['label' => 'छ', 'value' => 1],
                            ['label' => 'छैन', 'value' => 0]
                        ]
                    ],
                    [
                        'name' => 'मध्यमकालीन खर्च संरचना तयार तयार गर्न प्राविधिक सहयोग चाहिने/ नचाहिने',
                        'type' => 'radio',
                        'is_required' => 1,
                        'options' => [
                            ['label' => 'छ', 'value' => 1],
                            ['label' => 'छैन', 'value' => 0]
                        ]
                    ],
                ],
            ],
            [
                'name' => 'CD PLAN',
                'fields' => [
                    [
                        'name' => 'पालिकाको क्षमता विकास योजना तयारी भए/नभएको ',
                        'type' => 'radio',
                        'is_required' => 1,
                        'options' => [
                            ['label' => 'भएको', 'value' => 1],
                            ['label' => 'नभएको', 'value' => 0]
                        ]
                    ],
                    [
                        'name' => 'तयार नभएको भए क्षमता विकास योजना तयार गर्न यो वर्ष योजना भए/ नभएको',
                        'type' => 'radio',
                        'is_required' => 1,
                        'options' => [
                            ['label' => 'भएको', 'value' => 1],
                            ['label' => 'नभएको', 'value' => 0]
                        ]
                    ],
                    [
                        'name' => 'तयार गर्ने योजना भए क्षमता विकास योजना तयार गर्न सहयोग चाहिने/नचाहिने',
                        'type' => 'radio',
                        'is_required' => 1,
                        'options' => [
                            ['label' => 'चाहिने', 'value' => 1],
                            ['label' => 'नचाहिने', 'value' => 0]
                        ]
                    ],
                ]
            ],
            [
                'name' => 'O&M',
                'fields' => [
                    [
                        'name' => 'संगठन तथा व्यवस्थापन अध्ययन गरे/नगरेको',
                        'type' => 'radio',
                        'is_required' => 1,
                        'options' => [
                            ['label' => 'गरेको', 'value' => 1],
                            ['label' => 'नगरेको', 'value' => 0]
                        ]
                    ],
                    [
                        'name' => 'राजस्व सम्भाव्यता अध्ययन गरेको/नगरेको',
                        'type' => 'radio',
                        'is_required' => 1,
                        'options' => [
                            ['label' => 'गरेको', 'value' => 1],
                            ['label' => 'नगरेको', 'value' => 0]
                        ]
                    ],
                    [
                        'name' => 'राजस्व सुधार योजना तयार भएको/नभएको',
                        'type' => 'radio',
                        'is_required' => 1,
                        'options' => [
                            ['label' => 'भएको', 'value' => 1],
                            ['label' => 'नभएको', 'value' => 0]
                        ]
                    ],
                    [
                        'name' => 'राजस्व सुधार योजना तयार नभएको भए यो आ.वा.मा तयार गर्ने योजना भए/नभएको',
                        'type' => 'radio',
                        'is_required' => 1,
                        'options' => [
                            ['label' => 'भएको', 'value' => 1],
                            ['label' => 'नभएको', 'value' => 0]
                        ]
                    ],
                    [
                        'name' => 'राजस्व सुधार योजना तयार गर्ने योजना भए प्राबिधिक तथा आर्थिक सहयोग चाहिने/ नचाहिने',
                        'type' => 'radio',
                        'is_required' => 1,
                        'options' => [
                            ['label' => 'चाहिने', 'value' => 1],
                            ['label' => 'नचाहिने', 'value' => 0]
                        ]
                    ],
                ],
            ],
            [
                'name' => 'PUBLIC HEARING',
                'fields' => [
                    [
                        'name' => 'सार्वजनिक सुनुवाई, सार्वजनिक लेखा परिक्षण नियमित रुपमा हुने गरे/नगरेको',
                        'type' => 'radio',
                        'is_required' => 1,
                        'options' => [
                            ['label' => 'गरेको', 'value' => 1],
                            ['label' => 'नगरेको', 'value' => 0]
                        ]
                    ],
                    [
                        'name' => 'पालिकाको वार्षिक वजेट तथा कार्यक्रम वेबसाइटमा नियमित रुपमा राखे/नराखेको',
                        'type' => 'radio',
                        'is_required' => 1,
                        'options' => [
                            ['label' => 'राखेको', 'value' => 1],
                            ['label' => 'नराखेको', 'value' => 0]
                        ]
                    ],
                    [
                        'name' => 'पालिकाले चौमासिक रुपमा आय व्यय  सार्वजनिक गरे/नगरेको',
                        'type' => 'radio',
                        'is_required' => 1,
                        'options' => [
                            ['label' => 'गरेको', 'value' => 1],
                            ['label' => 'नगरेको', 'value' => 0]
                        ]
                    ],
                    [
                        'name' => 'मलेप प्रतिवेदन सभामा छलफल हुने गरे/नगरेको ',
                        'type' => 'radio',
                        'is_required' => 1,
                        'options' => [
                            ['label' => 'गरेको', 'value' => 1],
                            ['label' => 'नगरेको', 'value' => 0]
                        ]
                    ],
                    [
                        'name' =>   'यो आ.वा.को लागि सार्वजनिक सुनुवाई गर्न प्राबिधिक र आर्थिक सहयोग  आवश्यक रहेको/नरहेको',
                        'type' => 'radio',
                        'is_required' => 1,
                        'options' => [
                            ['label' => 'रहेको', 'value' => 1],
                            ['label' => 'नरहेको', 'value' => 0]
                        ]
                    ],
                ]
            ],
            [
                'name' => 'SDG Localization',
                'fields' => [
                    [
                        'name' =>   'यो आ.वा.को लागि सार्वजनिक सुनुवाई गर्न प्राबिधिक र आर्थिक सहयोग  आवश्यक रहेको/नरहेको',
                        'type' => 'radio',
                        'is_required' => 1,
                        'options' => [
                            ['label' => 'बनिसकेको', 'value' => 1],
                            ['label' => 'बन्दैगरेको', 'value' => 2],
                            ['label' => 'नबनेको', 'value' => 3]
                        ],
                    ]
                ]
            ],
            [
                'name' => 'SDG Localization',
                'fields' => [
                    [
                        'name' =>   'यो आ.वा.को लागि सार्वजनिक सुनुवाई गर्न प्राबिधिक र आर्थिक सहयोग  आवश्यक रहेको/नरहेको',
                        'type' => 'radio',
                        'is_required' => 1,
                        'options' => [
                            ['label' => 'बनिसकेको', 'value' => 9],
                            ['label' => 'बन्दैगरेको', 'value' => 0],
                            ['label' => 'नबनेको', 'value' => 20]
                        ],
                    ]
                ]
            ],
        ];


        foreach ($templates as $template) {
            $newTemplate = Template::create([
                'name' => $template['name'],
            ]);
            foreach ($template['fields'] as $templateField) {
                TemplateField::create(array_merge(['template_id' => $newTemplate->id], $templateField));
            }
        }


    }
}
