<?php

namespace App\HelperClasses\Fetcher;

use App\Models\LocalGovernment;
use Illuminate\Support\Facades\Http;
use Illuminate\Support\Facades\Storage;

class Remainingdatafetch
{
    public static function execute(){
    $files=[
        'articles',
        'elected-officials',
        'elected-profile',
        'gallery',
        'important-places',
        'contact',
        'documents',
        'resource-map',
        'introduction',
        'staff',
        'wards',
        'ward-officials',
        'services',
        'slider',
        'emergency-numbers'
    ];

    foreach ($files as $file){
        Storage::disk('api')->delete($file.'.json');
        $dataStore = [];
        $lgs= LocalGovernment::where('id', 533)
            ->orWhere('id', 541)
            ->orWhere('id', 543)
            ->get();
        $i = 1;
        foreach ($lgs as $lg) {
            $data = Http::get($lg->website.'/'.$file.'-api')->json();
            $dataStore[$lg->id] = $data;
            echo $i++."\n";
        }

        Storage::disk('api')->put($file.'.json', json_encode($dataStore, JSON_PRETTY_PRINT));
    }

    }
}
