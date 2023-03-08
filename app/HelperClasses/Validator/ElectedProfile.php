<?php

namespace App\HelperClasses\Validator;

use Illuminate\Support\Facades\DB;

class ElectedProfile
{
    public static function execute()
    {
        DB::table('elected_profiles')->truncate();
        $elected_profiles = json_decode(file_get_contents(storage_path('app/backup'. DIRECTORY_SEPARATOR .'elected_profiles.json')), true);
        $new_elected_profiles = [];
        foreach ($elected_profiles as $lg => $lg_elected_profiles) {
            if (is_null($lg_elected_profiles)) {
                continue;
            }
            foreach ($lg_elected_profiles as $elected_profile) {
                $date_year='';
                $phone='';
                if(isset($elected_profile["जन्म मिति "])){
                    $date_year=$elected_profile["जन्म मिति "];
                }
                if(isset($elected_profile['जन्म मिति (वर्ष)'])){
                    $date_year=$elected_profile['जन्म मिति (वर्ष)'];
                }
                if(isset($elected_profile["Phone"])){
                    $phone=$elected_profile["Phone"];
                }
                if(isset($elected_profile['फोन नं'])){
                    $phone=$elected_profile['फोन नं'];
                }
                $new_elected_profiles[] = [
                    'lg_id' => $lg,
                    'title' => $elected_profile['Title'] ?? '',
                    'country_studied' => $elected_profile['अध्ययन गरेको देश'] ?? '',
                    'study_institute' => $elected_profile['अध्ययन संस्था'] ?? '',
                    'subject_of_the_study' => $elected_profile['अध्ययनको विषय'] ?? '',
                    'other' => $elected_profile["अन्य"] ?? '',
                    'mother_name' => $elected_profile['आमाको नाम'] ?? '',
                    'email' => $elected_profile["इमेल"] ?? '',
                    'kriti_prakashan' => $elected_profile['कृति प्रकाशन'] ?? '',
                    'date_of_birth_date' => $elected_profile['जन्म मिति (गते)'] ?? '',
                    'date_of_birth_month' => $elected_profile['जन्म मिति (महिना)'] ?? '',
                    'date_of_birth_year' => $date_year,
                    'district' => $elected_profile['जिल्ला'] ?? '',
                    'toll' => $elected_profile['टोल'] ?? '',
                    'husband_wife_name' => $elected_profile['पति/पत्निको नाम'] ?? '',
                    'position' => $elected_profile['पद'] ?? '',
                    'region' => $elected_profile['प्रदेश'] ?? '',
                    'photo' => $elected_profile['फोटो'] ?? '',
                    'phone' => $phone,
                    'father_name' => $elected_profile['बाबुको नाम'] ?? '',
                    'mother_tongue' => $elected_profile['मातृ भाषा'] ?? '',
                    'mobile' => $elected_profile['मोबाईल'] ?? '',
                    'political_experience' => $elected_profile['राजनीतिक अनुभव'] ?? '',
                    'political_party' => $elected_profile['राजनीतिक दल'] ?? '',
                    'gender' => $elected_profile['लिङ्ग'] ?? '',
                    'vada_no' => $elected_profile['वडा नं'] ?? '',
                    'past_occcupation_and_experience' => $elected_profile['विगतको पेशा र अनुभव'] ?? '',
                    'foreign_travel' => $elected_profile['विदेश भ्रमण'] ?? '',
                    'marital_status' => $elected_profile['वैवाहिक स्थिति'] ?? '',
                    'education_qualification' => $elected_profile['शैक्षिक योग्यता'] ?? '',
                    'local_level_type' => $elected_profile['स्थानीय तहको प्रकार'] ?? '',
                    'created_at'=>date('Y-m-d H:i:s'),
                    'updated_at'=>date('Y-m-d H:i:s')
                ];
            }
        }


        echo "Validated";

        $i = 0;
        foreach ($new_elected_profiles as $elected_profile) {
            DB::table('elected_profiles')->insert($elected_profile);
            echo $i++ . "\n";
        }


        echo "Completed Migrating Elected Profiles";

    }

}
