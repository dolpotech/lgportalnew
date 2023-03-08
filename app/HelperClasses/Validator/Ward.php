<?php

namespace App\HelperClasses\Validator;

use Illuminate\Support\Facades\DB;

class Ward
{
    public static function execute()
    {
        DB::table('wards')->truncate();
        $wards = json_decode(file_get_contents(storage_path('app/backup'.DIRECTORY_SEPARATOR.'wards.json')), true);

        $new_wards= [];

        foreach ($wards as $lg => $lg_ward) {
            if (is_null($lg_ward)) {
                continue;
            }
            foreach ($lg_ward as $ward) {
               $phone='';
               $population='';
               $doc='';
               if(isset($ward['Ward Contact Number'])){
                   $phone=$ward['Ward Contact Number'];
               }
               if(isset($ward["सम्पर्क नंं"])){
                   $phone=$ward["सम्पर्क नंं"];
               }
               if(isset($ward["वडा सम्पर्क नं."])){
                   $phone=$ward["वडा सम्पर्क नं."];
               }
              if(isset($ward['Population'])){
                  $population=$ward['Population'];
              }
              if(isset($ward["पुरुष"])){
                  $population=$ward["पुरुष"];
              }
              if(isset($ward["जनसंख्या"])){
                  $population=$ward["जनसंख्या"];
              }
              if(isset($ward['Supporting Documents'])){
                  $doc=$ward['Supporting Documents'];
              }
              if(isset($ward['वडा नक्सा'])){
                  $doc=$ward['वडा नक्सा'];
              }
                $new_wards[] = [
                    'lg_id' => $lg,
                    'language'=>$ward['Language'] ?? '',
                    'title' => $ward['Title'] ?? '',
                    'phone' => $phone,
                    'population' =>$population,
                    'body' => $ward['Body'] ?? '',
                    'image' => $ward['Image'] ?? '',
                    'supporting_documents' => $doc,
                    'nid' => $ward['Nid'] ?? '',
                    'weight_value'=>$ward['Weight value'] ?? '',
                    'created_at'=>date('Y-m-d H:i:s'),
                    'updated_at'=>date('Y-m-d H:i:s')

                ];

            }
        }
        echo "Validated";

        $i = 0;
        foreach ($new_wards as $ward) {
            DB::table('wards')->insert($ward);
            echo $i++."\n";
        }

        echo "Completed Migrating Wards";


    }
}
