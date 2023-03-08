<?php

namespace App\HelperClasses\CronValidator;

use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Storage;

class Electedofficials
{
    public static function execute()
    {
        if (Storage::disk('api')->exists('cronjob/elected-officials.json')) {
            DB::table('elected_officials')->truncate();
            $elected_officials = json_decode(file_get_contents(storage_path('app/cronjob' . DIRECTORY_SEPARATOR . 'elected-officials.json')), true);

            $new_elected_officials = [];

            foreach ($elected_officials as $lg => $lg_elected_officials) {
                if (is_null($lg_elected_officials)) {
                    continue;
                }
                foreach ($lg_elected_officials as $elected_official) {
                    $email_id = '';
                    $phone = '';

                    if (isset($elected_official['Email'])) {
                        $email_id = $elected_official['Email'];
                    }
                    if (isset($elected_official["ईमेल"])) {
                        $email_id = $elected_official["ईमेल"];

                    }
                    if (isset($elected_official['Phone'])) {
                        $phone = $elected_official['Phone'];
                    }
                    if (isset($elected_official['Phone Number'])) {
                        $phone = $elected_official['Phone Number'];
                    }


                    $new_elected_officials[] = [
                        'lg_id' => $lg,
                        'language' => $elected_official['Language'] ?? '',
                        'title' => $elected_official['Title'] ?? '',
                        'body' => $elected_official['Body'] ?? '',
                        'designation' => $elected_official['Designation'] ?? '',
                        'email' => $email_id,
                        'phone' => $phone,
                        'photo' => $elected_official['Photo'] ?? '',
                        'post_box' => $elected_official['Post Box'] ?? '',
                        'section' => $elected_official['Section'] ?? '',
                        'tenure' => $elected_official['Tenure'] ?? '',
                        'created_at' => date('Y-m-d H:i:s'),
                        'updated_at' => date('Y-m-d H:i:s')
                    ];
                }
            }


            echo "Validated";

            $i = 0;
            foreach ($new_elected_officials as $elected_official) {
                DB::table('elected_officials')->insert($elected_official);
                echo $i++ . "\n";
            }


            echo "Completed Migrating Elected Officials";

        }
        else{
            echo "No data migrated";
        }
    }

}
