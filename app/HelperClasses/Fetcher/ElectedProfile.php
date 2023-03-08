<?php

namespace App\HelperClasses\Fetcher;

use App\Models\LocalGovernment;
use Illuminate\Support\Facades\Http;
use Illuminate\Support\Facades\Storage;

class ElectedProfile
{
    public static function execute()
    {
        Storage::disk('api')->delete('backup/elected_profiles.json');

        $dataStore = [];
        $lgs = LocalGovernment::where('province_id', 5)->whereNotNull('email')->get();

        echo "Total elected profile :".$lgs->count()."\n";
        $i = 1;
        foreach ($lgs as $lg) {
            $elected_profiles = Http::get($lg->website.'/elected-profile-api')->json();
            $dataStore[$lg->id] = $elected_profiles;
            echo $i++."\n";
        }

        Storage::disk('api')->put('backup/elected_profiles.json', json_encode($dataStore, JSON_PRETTY_PRINT));
    }

}
