<?php

namespace App\HelperClasses\CronValidator;

use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Storage;

class EmergencyNumbers
{
    public static function execute()
    {
        if (Storage::disk('api')->exists('cronjob/emergency-numbers.json')) {
            DB::table('emergency_numbers')->truncate();
            $emergency_numbers = json_decode(file_get_contents(storage_path('app/cronjob' . DIRECTORY_SEPARATOR . 'emergency-numbers.json')), true);

            $new_emergency_numbers = [];
            foreach ($emergency_numbers as $lg => $lg_emergency_number) {
                if (is_null($lg_emergency_number)) {
                    continue;
                }
                foreach ($lg_emergency_number as $emergency_number) {
                    $phone = '';
                    if (isset($emergency_number['फोन'])) {
                        $phone = $emergency_number['फोन'];
                    }
                    if (isset($emergency_number['Phone Number'])) {
                        $phone = $emergency_number['Phone Number'];
                    }

                    $new_emergency_numbers[] = [
                        'lg_id' => $lg,
                        'title' => $emergency_number['Title'] ?? '',
                        'address' => $emergency_number['Address'] ?? '',
                        'phone' => $phone,
                        'created_at' => date('Y-m-d H:i:s'),
                        'updated_at' => date('Y-m-d H:i:s')
                    ];

                }
            }
            echo "Validated";

            $i = 0;
            foreach ($new_emergency_numbers as $emergency_number) {
                DB::table('emergency_numbers')->insert($emergency_number);
                echo $i++ . "\n";
            }

            echo "Completed Migrating emergency_number";


        }
        else{
            echo "No data migrated";
        }
    }

}
