<?php

namespace App\HelperClasses\Fetcher;

use App\Models\LocalGovernment;
use Illuminate\Support\Facades\Http;
use Illuminate\Support\Facades\Storage;

class Introduction
{
    public static function execute()
    {
        Storage::disk('api')->delete('backup/introductions.json');

        $dataStore = [];
        $lgs = LocalGovernment::where('province_id', 5)->whereNotNull('email')->get();

        echo "Total introduction :".$lgs->count()."\n";
        $i = 1;
        foreach ($lgs as $lg) {
            $introduction = Http::get($lg->website.'/introduction-api')->json();
            $dataStore[$lg->id] = $introduction;
            echo $i++."\n";
        }

        Storage::disk('api')->put('backup/introductions.json', json_encode($dataStore, JSON_PRETTY_PRINT));
    }

}
