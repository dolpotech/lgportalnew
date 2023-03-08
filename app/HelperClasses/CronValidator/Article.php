<?php

namespace App\HelperClasses\CronValidator;

use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Storage;

class Article
{
    public static function execute()
    {
        if (Storage::disk('api')->exists('cronjob/articles.json')) {
        DB::table('articles')->truncate();
        $articles = json_decode(file_get_contents(storage_path('app/cronjob'.DIRECTORY_SEPARATOR.'articles.json')), true);
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

        $i = 0;
        foreach ($new_articles as $article) {
            DB::table('articles')->insert($article);
            echo $i++."\n";
        }
        echo "Completed Migrating Articles";

    }else{

        echo "database not changed";
        }

    }
}
