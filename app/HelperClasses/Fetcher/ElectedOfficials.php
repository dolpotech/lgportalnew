<?php

namespace App\HelperClasses\Fetcher;

use App\Models\LocalGovernment;
use Illuminate\Support\Facades\Http;
use Illuminate\Support\Facades\Storage;

class ElectedOfficials
{
    public static function execute()
    {
        Storage::disk('api')->delete('backup/elected_officials.json');

        $dataStore = [];
        $lgs = LocalGovernment::where('province_id', 5)->whereNotNull('email')->get();


        echo "Total elected officials :".$lgs->count()."\n";
        $i = 1;
        foreach ($lgs as $lg) {
            $elected_officials = Http::get($lg->website.'/elected-officials-api')->json();
            $dataStore[$lg->id] = $elected_officials;
            echo $i++."\n";
        }

        Storage::disk('api')->put('backup/elected_officials.json', json_encode($dataStore, JSON_PRETTY_PRINT));
    }
}
