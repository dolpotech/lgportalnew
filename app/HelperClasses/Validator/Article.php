<?php

namespace App\HelperClasses\Validator;

use Illuminate\Support\Facades\DB;

class Article
{
    public static function execute()
    {
        DB::table('articles')->truncate();
        $articles = json_decode(file_get_contents(storage_path('app/backup'.DIRECTORY_SEPARATOR.'articles.json')), true);

        $new_articles = [];

        foreach ($articles as $lg => $lg_article) {
            if (is_null($lg_article)) {
                continue;
            }
            foreach ($lg_article as $article) {
                $new_articles[] = [
                    'lg_id' => $lg,
                    'title' => $article['Title'] ?? '',
                    'tags' => $article['Tags'] ?? '',
                    'body' => $article['Body'] ?? '',
                    'image' => $article['Image'] ?? '',
                    'supporting_documents' => $article['Supporting Documents'] ?? '',
                    'created_at'=>date('Y-m-d H:i:s'),
                    'updated_at'=>date('Y-m-d H:i:s')
                ];
            }
        }

//        $this->info("Validated");
        echo "Validated";

        $i = 0;
        foreach ($new_articles as $article) {
            DB::table('articles')->insert($article);
            echo $i++."\n";
        }

//        $this->info("Completed Migrating Articles");
        echo "Completed Migrating Articles";

    }

}
