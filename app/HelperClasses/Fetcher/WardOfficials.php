<?php

namespace App\HelperClasses\Fetcher;

use App\Models\LocalGovernment;
use Illuminate\Support\Facades\Http;
use Illuminate\Support\Facades\Storage;

class WardOfficials
{
    public static function execute()
    {
        Storage::disk('api')->delete('backup/ward_officials.json');

        $dataStore = [];
        $lgs = LocalGovernment::where('province_id', 5)->whereNotNull('email')->get();

        echo "Total Ward Officials :".$lgs->count()."\n";
        $i = 1;
        foreach ($lgs as $lg) {
            $ward_officials = Http::get($lg->website.'/ward-officials-api')->json();
            $dataStore[$lg->id] = $ward_officials;
            echo $i++."\n";
        }

        Storage::disk('api')->put('backup/ward_officials.json', json_encode($dataStore, JSON_PRETTY_PRINT));
    }
}
