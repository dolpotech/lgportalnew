<?php

namespace App\HelperClasses\Validator;

use Illuminate\Support\Facades\DB;

class EmergencyNumbers
{
    public static function execute()
    {
        DB::table('emergency_numbers')->truncate();
        $emergency_numbers = json_decode(file_get_contents(storage_path('app/backup'.DIRECTORY_SEPARATOR.'emergency_numbers.json')), true);

        $new_emergency_numbers = [];
        foreach ($emergency_numbers as $lg => $lg_emergency_number) {
            if (is_null($lg_emergency_number)) {
                continue;
            }
            foreach ($lg_emergency_number as $emergency_number) {
                $phone='';
                if(isset($emergency_number['फोन'])){
                    $phone=$emergency_number['फोन'];
                }
               if(isset($emergency_number['Phone Number'])){
                   $phone=$emergency_number['Phone Number'];
               }

                $new_emergency_numbers[] = [
                    'lg_id' => $lg,
                    'title' => $emergency_number['Title'] ?? '',
                    'address'=> $emergency_number['Address'] ?? '',
                    'phone'=>$phone,
                    'created_at'=>date('Y-m-d H:i:s'),
                    'updated_at'=>date('Y-m-d H:i:s')
                ];

            }
        }
        echo "Validated";

        $i = 0;
        foreach ($new_emergency_numbers as $emergency_number) {
            DB::table('emergency_numbers')->insert($emergency_number);
            echo $i++."\n";
        }

        echo "Completed Migrating emergency_number";


    }

}
