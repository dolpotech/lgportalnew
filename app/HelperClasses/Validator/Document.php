<?php

namespace App\HelperClasses\Validator;

use Illuminate\Support\Facades\DB;

class Document
{
    public static function execute()
    {
        DB::table('lg_documents')->truncate();
        $documents = json_decode(file_get_contents(storage_path('app/backup'.DIRECTORY_SEPARATOR.'document.json')), true);

        $new_documents = [];
        foreach ($documents as $lg => $lg_document) {
            if (is_null($lg_document)) {
                continue;
            }
            foreach ($lg_document as $document) {
                $type = '';
                $doc='';
                if (isset($document['Document Type'])) {
                    $type = $document['Document Type'];
                }
                if (isset($document['प्रकार '])) {
                    $type = $document['प्रकार '];
                }
                if (isset($document["document"])) {
                    $doc = $document["document"];
                }
                if(isset($document["Documents"])){
                    $doc=$document["Documents"];
                }
                if(isset($document['दस्तावेज'])) {
                    $doc=$document['दस्तावेज'];
                }
                if(isset($document["File"])){
                    $doc=$document["File"];

                }

                $new_documents[] = [
                    'lg_id' => $lg,
                    'language'=>$document['Language'] ?? '',
                    'title' => $document['Title'] ?? '',
                    'body' => $document['Body'] ?? '',
                    'document_type' => $type,
                    'documents' => $doc,
                    'image' => $document['Image'] ?? '',
                    'created_at'=>date('Y-m-d H:i:s'),
                    'updated_at'=>date('Y-m-d H:i:s')
                ];

            }
        }
        echo "Validated";

        $i = 0;
        foreach ($new_documents as $document) {
            DB::table('lg_documents')->insert($document);
            echo $i++."\n";
        }

        echo "Completed Migrating Documents";


    }
}
