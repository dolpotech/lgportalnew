<?php

namespace App\HelperClasses\Fetcher;

use App\Models\LocalGovernment;
use Illuminate\Support\Facades\Http;
use Illuminate\Support\Facades\Storage;

class EmergencyNumbers
{
    public static function execute()
    {
        Storage::disk('api')->delete('backup/emergency_numbers.json');

        $dataStore = [];
        $lgs = LocalGovernment::where('province_id', 5)->whereNotNull('email')->get();

        echo "Total emergency numbers :".$lgs->count()."\n";
        $i = 1;
        foreach ($lgs as $lg) {
            $emergency_numbers = Http::get($lg->website.'/emergency-numbers-api')->json();
            $dataStore[$lg->id] = $emergency_numbers;
            echo $i++."\n";
        }

        Storage::disk('api')->put('backup/emergency_numbers.json', json_encode($dataStore, JSON_PRETTY_PRINT));
    }
}
