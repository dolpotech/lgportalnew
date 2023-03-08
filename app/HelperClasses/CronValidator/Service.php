<?php

namespace App\HelperClasses\CronValidator;

use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Storage;

class Service
{
    public static function execute()
    {
        if (Storage::disk('api')->exists('cronjob/services.json')) {
            DB::table('services')->truncate();
            $services = json_decode(file_get_contents(storage_path('app/cronjob' . DIRECTORY_SEPARATOR . 'services.json')), true);

            $new_services = [];
            foreach ($services as $lg => $lg_service) {
                if (is_null($lg_service)) {
                    continue;
                }
                foreach ($lg_service as $service) {

                    $new_services[] = [
                        'lg_id' => $lg,
                        'title' => $service['Title'] ?? '',
                        'language' => $service['Language'] ?? '',
                        'service_type' => $service['सेवा प्रकार'] ?? '',
                        'service_time' => $service['सेवा समय'] ?? '',
                        'responsible_officer' => $service['जिम्मेवार अधिकारी'] ?? '',
                        'service_office' => $service['सेवा दिने कार्यालय'] ?? '',
                        'service_fee' => $service['सेवा शुल्क'] ?? '',
                        'required_documents' => $service['आवश्यक कागजातहरु'] ?? '',
                        'related_documents' => $service['सम्बन्धित कागजातहरु'] ?? '',
                        'process' => $service['प्रक्रिया'] ?? '',
                        'body' => $service['Body'] ?? '',
                        'created_at' => date('Y-m-d H:i:s'),
                        'updated_at' => date('Y-m-d H:i:s')
                    ];

                }
            }
            echo "Validated";

            $i = 0;
            foreach ($new_services as $service) {
                DB::table('services')->insert($service);
                echo $i++ . "\n";
            }

            echo "Completed Migrating Services";

        }
        else{
            echo "No data migrated";
        }
    }
}
