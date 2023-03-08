<?php

namespace App\HelperClasses\Fetcher;

use App\Models\LocalGovernment;
use Illuminate\Support\Facades\Http;
use Illuminate\Support\Facades\Storage;

class ImportantPlaces
{
    public static function execute()
    {
        Storage::disk('api')->delete('backup/important_places.json');

        $dataStore = [];
        $lgs = LocalGovernment::where('province_id', 5)->whereNotNull('email')->get();

        echo "Total Important Places :".$lgs->count()."\n";
        $i = 1;
        foreach ($lgs as $lg) {
            $important_places = Http::get($lg->website.'/important-places-api')->json();
            $dataStore[$lg->id] = $important_places;
            echo $i++."\n";
        }

        Storage::disk('api')->put('backup/important_places.json', json_encode($dataStore, JSON_PRETTY_PRINT));
    }
}
