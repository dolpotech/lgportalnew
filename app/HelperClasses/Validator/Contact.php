<?php

namespace App\HelperClasses\Validator;

use App\HelperClasses\Traits\NepalitoEnglish;
use Illuminate\Support\Facades\DB;

class Contact
{
    use NepalitoEnglish;
    public static function execute()
    {

        DB::table('contacts')->truncate();
        $contacts = json_decode(file_get_contents(storage_path('app/backup'.DIRECTORY_SEPARATOR.'contacts.json')), true);

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
                    'created_at'=>date('Y-m-d H:i:s'),
                    'updated_at'=>date('Y-m-d H:i:s')
                ];
            }
        }

//        $this->info("Validated");
        echo "Validated";

        $i = 0;
        foreach ($new_contacts as $contact) {
            DB::table('contacts')->insert($contact);
            echo $i++."\n";
        }

//        $this->info("Completed Migrating Articles");
        echo "Completed Migrating Contacts";

    }


}
