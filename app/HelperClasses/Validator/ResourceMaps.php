<?php

namespace App\HelperClasses\Validator;

use Illuminate\Support\Facades\DB;

class ResourceMaps
{
    public static function execute()
    {
        DB::table('resource_maps')->truncate();
        $resource_maps = json_decode(file_get_contents(storage_path('app/backup'. DIRECTORY_SEPARATOR .'resource_maps.json')), true);

        $new_resource_maps= [];

        foreach ($resource_maps as $lg => $lg_resource_maps) {
            if (is_null($lg_resource_maps)) {
                continue;
            }
            foreach ($lg_resource_maps as $resource_map) {
                $new_resource_maps[] = [
                    'lg_id' => $lg,
                    'language' => $resource_map['Language'] ?? '',
                    'title' => $resource_map['Title'] ?? '',
                    'body' => $resource_map['Body'] ?? '',
                    'created_at'=>date('Y-m-d H:i:s'),
                    'updated_at'=>date('Y-m-d H:i:s')
                ];
            }
        }


        echo "Validated";

        $i = 0;
        foreach ($new_resource_maps as $resource_map) {
            DB::table('resource_maps')->insert($resource_map);
            echo $i++ . "\n";
        }


        echo "Completed Migrating Resource Maps";

    }
}
