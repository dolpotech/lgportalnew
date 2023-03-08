<?php

namespace App\HelperClasses\Fetcher;

use App\Models\LocalGovernment;
use Illuminate\Support\Facades\Http;
use Illuminate\Support\Facades\Storage;

class WardsFetcher
{
    public static function execute()
    {
        Storage::disk('api')->delete('backup/wards.json');

        $dataStore = [];
        $lgs = LocalGovernment::where('province_id', 5)->whereNotNull('email')->get();

        echo "Total Wards :".$lgs->count()."\n";
        $i = 1;
        foreach ($lgs as $lg) {
            $articles = Http::get($lg->website.'/wards-api')->json();
            $dataStore[$lg->id] = $articles;
            echo $i++."\n";
        }

        Storage::disk('api')->put('backup/wards.json', json_encode($dataStore, JSON_PRETTY_PRINT));
    }

}
