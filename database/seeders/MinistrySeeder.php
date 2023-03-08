<?php

namespace Database\Seeders;

use App\Models\Ministry;
use Illuminate\Database\Seeder;

class MinistrySeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $ministries = [
            [
                'name' => 'मुख्यमन्त्री तथा मन्त्रिपरिषदको कार्यालय',
                'name_en' => 'Office of Chief Minister and Council of Ministry',
                'website' => 'ocmcm.lumbini.gov.np',
                'email' => 'info.ocmcm@lumbini.gov.np',
                'phone_no' => '71550610',
                'province_id' => 5,
            ],
            [
                'name' => 'आर्थिक मामिला तथा सहकारी मन्त्रालय',
                'name_en' => 'Ministry of Economic Affairs and Co-operatives',
                'website' => 'https://moeap.lumbini.gov.np/',
                'email' => 'info.moeap@lumbini.gov.np',
                'phone_no' => '71550063',
                'province_id' => 5,
            ],
            [
                'name' => 'आन्तरिक मामिला तथा संचार मन्त्रालय',
                'name_en' => 'Ministry of Internal Affairs and Communications',
                'website' => 'https://moial.lumbini.gov.np/',
                'email' => 'internalaffairsp5@gmail.com',
                'phone_no' => '71550627',
                'province_id' => 5,
            ],
            [
                'name' => 'पर्यटन, ग्रामिण तथा शहरी विकास मन्त्रालय',
                'name_en' => 'Ministry of Tourism, Rural and Urban Development',
                'website' => 'https://morud.lumbini.gov.np/',
                'email' => 'morud.lumbini@gmail.com',
                'phone_no' => '9857083032',
                'province_id' => 5,
            ],
            [
                'name' => 'उर्जा,जलस्रोत तथा सिचाई मन्त्रालय',
                'name_en' => 'Ministry of Energy, Water Resources and Irrigation',
                'website' => 'https://moewri.lumbini.gov.np/',
                'email' => 'info.moewri@lumbini.gov.np',
                'phone_no' => '9857033073',
                'province_id' => 5,
            ],
            [
                'name' => 'कानून,महिला बालबालिका तथा जेष्ठ नागरिक मन्त्रालय',
                'name_en' => 'Ministry of Law, Women, Child and Senior Citizens',
                'website' => 'https://molwcsc.lumbini.gov.np/',
                'email' => 'molwcsc@gmail.com',
                'phone_no' => '9857083160',
                'province_id' => 5,
            ],
            [
                'name' => 'कृषि ,खाध प्रबिधि तथा भुमि व्यवस्था मन्त्रालय',
                'name_en' => 'Ministry of Agriculture, Land Management and Cooperatives',
                'website' => 'https://molmac.lumbini.gov.np/',
                'email' => 'molmacplanning@gmail.com',
                'phone_no' => '71540051',
                'province_id' => 5,
            ],
            [
                'name' => 'उद्योग, वाणिज्य तथा आपूर्ति मन्त्रालय',
                'name_en' => 'Ministry of Industry, Commerce and Supplies',
                'website' => 'https://moics.lumbini.gov.np/',
                'email' => 'moici.lumbini@gmail.com',
                'phone_no' => '71543608',
                'province_id' => 5,
            ],
            [
                'name' => 'बन, वातावरण तथा भू-संरक्षण मन्त्रालय',
                'name_en' => 'Ministry of Forest, Environment and Soil Conservation',
                'website' => 'https://moitfe.lumbini.gov.np/',
                'email' => 'mofesc.lumbini@gmail.com',
                'phone_no' => '71551216',
                'province_id' => 5,
            ],
            [
                'name' => 'शिक्षा,बिज्ञान, युवा तथा खेलकुद मन्त्रालय',
                'name_en' => 'Ministry of Education, Science, Youth and Sports',
                'website' => 'https://mosd.lumbini.gov.np/',
                'email' => 'mosdfive@gmail.com',
                'phone_no' => '71550646',
                'province_id' => 5,
            ],
            [
                'name' => 'श्रम रोजगार तथा यातायात व्यवस्था मन्त्रालय',
                'name_en' => 'Ministry of Labour, Employment and Transport Management',
                'website' => 'https://moletm.lumbini.gov.np/',
                'email' => 'info.moletm@lumbini.gov.np',
                'phone_no' => '71542734',
                'province_id' => 5,
            ],
            [
                'name' => 'स्वास्थ्य, जनसंख्या तथा परिवार कल्याण मन्त्रालय',
                'name_en' => 'Ministry of Health, Population and Family Welfare',
                'website' => 'https://mohp.lumbini.gov.np/',
                'email' => 'mohp.lumbini@gmail.com',
                'phone_no' => '71543004',
                'province_id' => 5,
            ],
            [
                'name' => 'भौतिक पूर्वाधार विकास मन्त्रालय',
                'name_en' => 'Ministry of Physical Infrastructure Development',
                'website' => 'https://mopid.lumbini.gov.np/',
                'email' => 'mopid.lumbini@gmail.com',
                'phone_no' => '71503365',
                'province_id' => 5,
            ],
        ];

        Ministry::insert($ministries);
    }
}
