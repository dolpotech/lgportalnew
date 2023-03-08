<?php

namespace App\HelperClasses\Fetcher;

use App\Models\LocalGovernment;
use Illuminate\Support\Facades\Http;
use Illuminate\Support\Facades\Storage;

class GalleryFetcher
{
    public static function execute()
    {
        Storage::disk('api')->delete('backup/galleries.json');

        $dataStore = [];
        $lgs = LocalGovernment::where('province_id', 5)->whereNotNull('email')->get();

        echo "Total Galleries :".$lgs->count()."\n";
        $i = 1;
        foreach ($lgs as $lg) {
            $galleries = Http::get($lg->website.'/gallery-api')->json();
            $dataStore[$lg->id] = $galleries;
            echo $i++."\n";
        }

        Storage::disk('api')->put('backup/galleries.json', json_encode($dataStore , JSON_PRETTY_PRINT));
    }

}
