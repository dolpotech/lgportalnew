<?php

namespace App\HelperClasses\Fetcher;

use App\Models\LocalGovernment;
use Illuminate\Support\Facades\Http;
use Illuminate\Support\Facades\Storage;

class ContactFetcher
{
    public static function execute()
    {
        Storage::disk('api')->delete('backup/contacts.json');

        $dataStore = [];
        $lgs = LocalGovernment::where('province_id', 5)->whereNotNull('email')->get();

        echo "Total Contacts :".$lgs->count()."\n";
        $i = 1;
        foreach ($lgs as $lg) {
            $contacts = Http::get($lg->website.'/contact-api')->json();
            $dataStore[$lg->id] = $contacts;
            echo $i++."\n";
        }

        Storage::disk('api')->put('backup/contacts.json', json_encode($dataStore, JSON_PRETTY_PRINT));
    }

}
