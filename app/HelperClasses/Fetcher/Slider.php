<?php

namespace App\HelperClasses\Fetcher;

use App\Models\LocalGovernment;
use Illuminate\Support\Facades\Http;
use Illuminate\Support\Facades\Storage;

class Slider
{
    public static function execute()
    {
        Storage::disk('api')->delete('backup/sliders.json');

        $dataStore = [];
        $lgs = LocalGovernment::where('province_id', 5)->whereNotNull('email')->get();

        echo "Total sliders:".$lgs->count()."\n";
        $i = 1;
        foreach ($lgs as $lg) {
            $sliders = Http::get($lg->website.'/slider-api')->json();
            $dataStore[$lg->id] = $sliders;
            echo $i++."\n";
        }

        Storage::disk('api')->put('backup/sliders.json', json_encode($dataStore, JSON_PRETTY_PRINT));
    }
}
