<?php

namespace App\HelperClasses\Fetcher;

use App\Models\LocalGovernment;
use Illuminate\Support\Facades\Http;
use Illuminate\Support\Facades\Storage;

class ResourceMap
{
    public static function execute()
    {
        Storage::disk('api')->delete('backup/resource_map.json');

        $dataStore = [];
        $lgs = LocalGovernment::where('province_id', 5)->whereNotNull('email')->get();

        echo "Total Resource Maps :".$lgs->count()."\n";
        $i = 1;
        foreach ($lgs as $lg) {
            $resource_maps = Http::get($lg->website.'/resource-map-api')->json();
            $dataStore[$lg->id] = $resource_maps;
            echo $i++."\n";
        }

        Storage::disk('api')->put('backup/resource_maps.json', json_encode($dataStore, JSON_PRETTY_PRINT));
    }
}
