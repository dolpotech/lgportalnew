<?php

namespace App\HelperClasses\Fetcher;

use App\Models\LocalGovernment;
use Illuminate\Support\Facades\Http;
use Illuminate\Support\Facades\Storage;

class StaffsFetcher
{
    public static function execute()
    {
        Storage::disk('api')->delete('backup/staffs.json');

        $dataStore = [];
        $lgs = LocalGovernment::where('province_id', 5)->whereNotNull('email')->get();

        echo "Total  Staff :".$lgs->count()."\n";
        $i = 1;
        foreach ($lgs as $lg) {
            $staffs = Http::get($lg->website.'/staff-api')->json();
            $dataStore[$lg->id] = $staffs;
            echo $i++."\n";
        }

        Storage::disk('api')->put('backup/staffs.json', json_encode($dataStore, JSON_PRETTY_PRINT));
    }
}
