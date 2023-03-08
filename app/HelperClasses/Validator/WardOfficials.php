<?php

namespace App\HelperClasses\Validator;

use Illuminate\Support\Facades\DB;

class WardOfficials
{
    public static function execute()
    {
        DB::table('ward_officials')->truncate();
        $ward_officials = json_decode(file_get_contents(storage_path('app/backup'. DIRECTORY_SEPARATOR .'ward_officials.json')), true);

        $new_ward_officials = [];

        foreach ($ward_officials as $lg => $lg_ward_officials) {
            if (is_null($lg_ward_officials)) {
                continue;
            }
            foreach ($lg_ward_officials as $ward_official) {
                $phone='';
                $email='';
                if(isset($ward_official["Phone Number"])){
                    $phone=$ward_official["Phone Number"];
                }
                if(isset($ward_official['फोन'])){
                    $phone=$ward_official['फोन'];
                }
                if(isset($ward_official['Email'])){
                    $email=$ward_official['Email'];
                }
                if(isset($ward_official['ईमेल'])){
                    $email=$ward_official['ईमेल'];

                }

                $new_ward_officials[] = [
                    'lg_id' => $lg,
                    'language' => $ward_official['Language'] ?? '',
                    'title' => $ward_official['Title'] ?? '',
                    'body' => $ward_official['Body'] ?? '',
                    'image' => $ward_official['Image'] ?? '',
                    'designation' => $ward_official['Designation'] ?? '',
                    'email' => $email,
                    'phone' => $phone,
                    'ward' => $ward_official['Ward'] ?? '',
                    'created_at'=>date('Y-m-d H:i:s'),
                    'updated_at'=>date('Y-m-d H:i:s')
                ];
            }
        }


        echo "Validated";

        $i = 0;
        foreach ($new_ward_officials as $ward_official) {
            DB::table('ward_officials')->insert($ward_official);
            echo $i++ . "\n";
        }


        echo "Completed Migrating Ward Officials";

    }

}
