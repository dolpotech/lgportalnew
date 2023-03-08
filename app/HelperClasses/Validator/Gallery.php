<?php

namespace App\HelperClasses\Validator;

use Illuminate\Support\Facades\DB;

class Gallery
{
    public static function execute()
    {
        DB::table('galleries')->truncate();
        $galleries = json_decode(file_get_contents(storage_path('app/backup'.DIRECTORY_SEPARATOR.'galleries.json')), true);

        $new_galleries= [];

        foreach ($galleries as $lg => $lg_gallery) {
            if (is_null($lg_gallery)) {
                continue;
            }
            foreach ($lg_gallery as $gallery) {
               $img='';
               if(isset($gallery['Images'])){
                   $img=$gallery['Images'];

               }
               if(isset($gallery["image upload"])){
                   $img=$gallery["image upload"];
               }
                $new_galleries[] = [
                    'lg_id' => $lg,
                    'language'=>$gallery['Language'] ?? '',
                    'title' => $gallery['Title'] ?? '',
                    'body' => $gallery['Body'] ?? '',
                    'images' =>$img,
                    'created_at'=>date('Y-m-d H:i:s'),
                    'updated_at'=>date('Y-m-d H:i:s')
                ];

            }
        }
        echo "Validated";

        $i = 0;
        foreach ($new_galleries as $gallery) {
            DB::table('galleries')->insert($gallery);
            echo $i++."\n";
        }

        echo "Completed Migrating Galleries";


    }

}
