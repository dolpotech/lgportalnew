<?php

namespace App\HelperClasses\Traits;

use App\Models\Contact;
use App\Models\Document;
use App\Models\ElectedOfficials;
use App\Models\ResourceMap;
use App\Models\Service;
use App\Models\Staff;
use ProtoneMedia\LaravelCrossEloquentSearch\Search;
use App\Models\Article;
trait ArticlesSearch
{
public function article_search($searchKey){
    $query = Search::new();
    $articles= $query->add($this->getQuery(Contact::class), Contact::searchColumn())
        ->add($this->getQuery(Article::class), Article::searchColumn())
        ->beginWithWildcard()
        ->endWithWildcard('false')
        ->dontParseTerm()
        ->includeModelType()
        ->paginate(10)
        ->search($searchKey);


     foreach ($articles as $data){
            $article_ids[]=$data->id;
        }
     foreach($article_ids as $article_id) {
             $article = Article::find($article_id);
             $initial_search = $article->searched;
             $article->searched = $initial_search+1;
             $article->save();
         }
         return 1;
}

}
