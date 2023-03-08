<?php

namespace App\HelperClasses\Validator;

use Illuminate\Support\Facades\DB;

class Slider
{
    public static function execute()
    {
        DB::table('sliders')->truncate();
        $sliders= json_decode(file_get_contents(storage_path('app/backup'.DIRECTORY_SEPARATOR.'sliders.json')), true);

        $new_sliders= [];

        foreach ($sliders as $lg => $lg_slider) {
            if (is_null($lg_slider)) {
                continue;
            }
            foreach ($lg_slider as $slider) {

                $new_sliders[] = [
                    'lg_id' => $lg,
                    'title'=>$slider['Title'] ?? '',
                    'image' =>$slider['Image'] ?? '',
                    'created_at'=>date('Y-m-d H:i:s'),
                    'updated_at'=>date('Y-m-d H:i:s')
                ];

            }
        }
        echo "Validated";

        $i = 0;
        foreach ($new_sliders as $slider) {
            DB::table('sliders')->insert($slider);
            echo $i++."\n";
        }

        echo "Completed Migrating Sliders";


    }

}
