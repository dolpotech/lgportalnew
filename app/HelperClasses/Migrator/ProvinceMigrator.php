<?php

namespace App\HelperClasses\Migrator;

use App\Models\Province;
use Illuminate\Support\Facades\DB;

class ProvinceMigrator
{


    public static function execute()
    {
        Province::truncate();
        $provinces=DB::connection('mysql2')->table('pradeshes')->get()->toArray();

        $modified_provinces = array_map(function ($province) {
            return [
                'name' => $province->pradesh_name
            ];
        }, $provinces);

        Province::insert($modified_provinces);
    }

}
