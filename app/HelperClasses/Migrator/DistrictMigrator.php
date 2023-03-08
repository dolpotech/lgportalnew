<?php

namespace App\HelperClasses\Migrator;

use App\Models\District;
use App\Models\Province;
use Illuminate\Support\Facades\DB;

class DistrictMigrator
{


    public static function execute()
    {
        District::truncate();
        $districts=DB::table('lg')->select('district_id','district_name_ne','district_name_en')
                    ->distinct()
                    ->get()
                    ->toArray();

        $modified_districts = array_map(function ($district) {
            return [
                'id'=>$district->district_id,
                'province_id' => 5,
                'name'=>$district->district_name_ne,
                'name_en'=>$district->district_name_en
            ];
        }, $districts);

        District::insert( $modified_districts);
    }

}
