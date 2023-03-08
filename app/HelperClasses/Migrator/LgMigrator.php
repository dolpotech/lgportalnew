<?php

namespace App\HelperClasses\Migrator;

use App\Models\District;
use App\Models\LocalGovernment;
use Illuminate\Support\Facades\DB;

class LgMigrator
{
    public static function execute()
    {
        LocalGovernment::truncate();
        $lg=DB::table('lg')->get()->toArray();

        $modified_lg = array_map(function ($local_government) {
            return [
                'id'=>$local_government->lgid,
                'province_id' =>5,
                'district_id'=>$local_government->district_id,
                'name'=>$local_government->lg_name_np_full,
                'name_en'=>$local_government->lg_name_en_full,
                'website'=>$local_government->webiste,
                'email'=>$local_government->Official_Email,
                'information_official_email'=>$local_government->Information_Officer_Email,
                'type'=>$local_government->lg_type_en,
                'type_nep'=>$local_government->lg_type_ne,

            ];
        }, $lg);

        LocalGovernment::insert($modified_lg );
    }
}
