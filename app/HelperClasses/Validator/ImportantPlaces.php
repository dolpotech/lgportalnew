<?php

namespace App\HelperClasses\Validator;

use Illuminate\Support\Facades\DB;

class ImportantPlaces
{
    public static function execute()
    {
        DB::table('important_places')->truncate();
        $important_places = json_decode(file_get_contents(storage_path('app/backup'. DIRECTORY_SEPARATOR .'important_places.json')), true);

        $new_important_places = [];

        foreach ($important_places as $lg => $lg_important_places) {
            if (is_null($lg_important_places)) {
                continue;
            }
            foreach ($lg_important_places as $important_place) {

                $new_important_places[] = [
                    'lg_id' => $lg,
                    'title' => $important_place['Title'] ?? '',
                    'category' => $important_place['Category'] ?? '',
                    'latitude' => $important_place['Latitude'] ?? '',
                    'longitude' => $important_place['Longitude'] ?? '',
                    'nid' => $important_place['Nid'] ?? '',
                    'created_at'=>date('Y-m-d H:i:s'),
                    'updated_at'=>date('Y-m-d H:i:s')
                ];
            }
        }


        echo "Validated";

        $i = 0;
        foreach ($new_important_places as $important_place) {
            DB::table('important_places')->insert($important_place);
            echo $i++ . "\n";
        }


        echo "Completed Migrating Important Places";

    }

}
