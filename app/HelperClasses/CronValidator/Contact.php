<?php

namespace App\HelperClasses\CronValidator;

use App\HelperClasses\Traits\NepalitoEnglish;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Storage;

class Contact
{
    use NepalitoEnglish;
    public static function execute()
    {
        if (Storage::disk('api')->exists('cronjob/contact.json')) {
            DB::table('contacts')->truncate();
            $contacts = json_decode(file_get_contents(storage_path('app/cronjob' . DIRECTORY_SEPARATOR . 'contact.json')), true);

            $new_contacts = [];

            foreach ($contacts as $lg => $lg_contacts) {
                if (is_null($lg_contacts)) {
                    continue;
                }
                foreach ($lg_contacts as $contact) {
                    $new_contacts[] = [
                        'lg_id' => $lg,
                        'title' => $contact['Title'] ?? '',
                        'address' => $contact['Address'] ?? '',
                        'telephone' => $contact['Telephone'] ?? '',
                        'email' => $contact['Email'] ?? '',
                        'latitude' => $contact['Latitude'] ?? '',
                        'longitude' => $contact['Longitude'] ?? '',
                        'created_at' => date('Y-m-d H:i:s'),
                        'updated_at' => date('Y-m-d H:i:s')
                    ];
                }
            }

//        $this->info("Validated");
            echo "Validated";

            $i = 0;
            foreach ($new_contacts as $contact) {
                DB::table('contacts')->insert($contact);
                echo $i++ . "\n";
            }

//        $this->info("Completed Migrating Articles");
            echo "Completed Migrating Contacts";

        }
        else{
            echo "data not migrated";
        }
    }


}
