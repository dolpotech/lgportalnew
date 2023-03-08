<?php

namespace App\HelperClasses\CronValidator;

use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Storage;

class Introduction
{
    public static function execute()
    {
        if (Storage::disk('api')->exists('cronjob/introduction.json')) {
            DB::table('introductions')->truncate();
            $introductions = json_decode(file_get_contents(storage_path('app/cronjob' . DIRECTORY_SEPARATOR . 'introduction.json')), true);

            $new_introductions = [];

            foreach ($introductions as $lg => $lg_introduction) {
                if (is_null($lg_introduction)) {
                    continue;
                }
                foreach ($lg_introduction as $introduction) {

                    $new_introductions[] = [
                        'lg_id' => $lg,
                        'language' => $introduction['Language'] ?? '',
                        'title' => $introduction['Title'] ?? '',
                        'body' => $introduction['Body'] ?? '',
                        'created_at' => date('Y-m-d H:i:s'),
                        'updated_at' => date('Y-m-d H:i:s')
                    ];
                }
            }

//        $this->info("Validated");
            echo "Validated";

            $i = 0;
            foreach ($new_introductions as $introduction) {
                DB::table('introductions')->insert($introduction);
                echo $i++ . "\n";
            }

//        $this->info("Completed Migrating Articles");
            echo "Completed migrating introduction";

        }
        else{
            echo "No data migrated";
        }
    }

}
