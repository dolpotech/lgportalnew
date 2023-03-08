<?php

namespace App\HelperClasses\Fetcher;

use App\Models\LocalGovernment;
use Illuminate\Support\Facades\Http;
use Illuminate\Support\Facades\Storage;

class ServiceFetcher
{
    public static function execute()
    {
        Storage::disk('api')->delete('backup/services.json');

        $dataStore = [];
        $lgs = LocalGovernment::where('province_id', 5)->whereNotNull('email')->get();

        echo "Total Services :".$lgs->count()."\n";
        $i = 1;
        foreach ($lgs as $lg) {
            $services = Http::get($lg->website.'/services-api')->json();
            $dataStore[$lg->id] = $services;
            echo $i++."\n";
        }

        Storage::disk('api')->put('backup/services.json', json_encode($dataStore , JSON_PRETTY_PRINT));
    }
}
