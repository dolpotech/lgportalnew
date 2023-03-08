<?php

namespace App\HelperClasses\Fetcher;

use App\Models\LocalGovernment;
use Illuminate\Support\Facades\Http;
use Illuminate\Support\Facades\Storage;

class DocumentsFetcher
{
    public static function execute()
    {
        Storage::disk('api')->delete('backup/document.json');

        $dataStore = [];
        $lgs = LocalGovernment::where('province_id', 5)->whereNotNull('email')->get();
        echo "Total Documents :".$lgs->count()."\n";
        $i = 1;
        foreach ($lgs as $lg) {
            $documents = Http::get($lg->website.'/documents-api')->json();
            $dataStore[$lg->id] = $documents;
            echo $i++."\n";
        }

        Storage::disk('api')->put('backup/document.json', json_encode($dataStore , JSON_PRETTY_PRINT));
    }
}
