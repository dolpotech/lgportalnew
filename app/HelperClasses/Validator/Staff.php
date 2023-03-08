<?php

namespace App\HelperClasses\Validator;

use Illuminate\Support\Facades\DB;

class Staff
{
    public static function execute()
    {
        DB::table('staffs')->truncate();
        $staffs = json_decode(file_get_contents(storage_path('app/backup'. DIRECTORY_SEPARATOR .'staffs.json')), true);

        $new_staffs = [];

        foreach ($staffs as $lg => $lg_staffs) {
            if (is_null($lg_staffs)) {
                continue;
            }
            foreach ($lg_staffs as $staff) {
               $phone='';
               if(isset($staff['Phone'])){
                   $phone=$staff['Phone'];
               }
               if(isset($staff['Phone Number'])){
                   $phone=$staff['Phone Number'];
               }

                $new_staffs[] = [
                    'lg_id' => $lg,
                    'language' => $staff['Language'] ?? '',
                    'title' => $staff['Title'] ?? '',
                    'body' => $staff['Body'] ?? '',
                    'designation' => $staff['Designation'] ?? '',
                    'email' =>$staff['Email'] ?? '',
                    'phone' =>$phone,
                    'photo' => $staff['Photo'] ?? '',
                    'post_box' => $staff['Post Box'] ?? '',
                    'section' => $staff['Section'] ?? '',
                    'tenure' => $staff['Tenure'] ?? '',
                    'created_at'=>date('Y-m-d H:i:s'),
                    'updated_at'=>date('Y-m-d H:i:s')
                ];
            }
        }


        echo "Validated";

        $i = 0;
        foreach ($new_staffs as $staff) {
            DB::table('staffs')->insert($staff);
            echo $i++ . "\n";
        }


        echo "Completed Migrating Staff";

    }
}
