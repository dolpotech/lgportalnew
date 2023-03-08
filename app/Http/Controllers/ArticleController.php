<?php

namespace App\Http\Controllers;

use App\HelperClasses\Traits\ApiResponse;
use App\Models\Article;
use App\Models\Document;
use App\Models\LocalGovernment;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class ArticleController extends Controller
{
    use ApiResponse;
    public  function list_of_article($id=null){
        if($id==null){
            $articles=DB::table('articles')->simplePaginate(10);
            return $this->sendApiSuccessResponse($articles, "list of articles", 1);
        }else {
            $lg = LocalGovernment::find($id);
            if ($lg != null) {
                $articles = Article::where('lg_id', $id)->get();
                return $this->sendApiSuccessResponse($articles, "list of articles", 1);
            } else {
                return ["Result" => "lg does not exist"];
            }
        }


    }

    public function view_increament($article_id){
        $article=Article::find($article_id);
        $initial_view=$article->viewed;
        $article->viewed=$initial_view+1;
        $save=$article->save();
        if($save){
            return[ "message"=> "Article views increase"];
        }

    }

    public function search_increment($article_id){
        $article=Article::find($article_id);
        $initial_search=$article->searched;
        $article->searched=$initial_search+1;
        $save=$article->save();
        if($save){
            return["message"=>"Article search value increased"];
        }


    }

    public function most_viewed(){
        $article=DB::table('articles')
                ->select(["articles.*", "local_governments.name as localgovernment_name"])
                ->join('local_governments', 'articles.lg_id', '=', 'local_governments.id')
                ->orderBy('viewed', 'desc')
                ->limit(5)
                 ->get();
        return $this->sendApiSuccessResponse($article, "most viewed article");
    }

    public function most_searched(){
        $article=DB::table('articles')
            ->select(["articles.*", "local_governments.name as localgovernment_name"])
            ->join('local_governments', 'articles.lg_id', '=', 'local_governments.id')
            ->orderBy('searched', 'desc')
            ->limit(5)
            ->get();
        return $this->sendApiSuccessResponse($article, "most searched article");

    }
    public function new_article(){
        $article=DB::table('articles')
                 ->select(["articles.*", "local_governments.name as localgovernment_name"])
                 ->join('local_governments', 'articles.lg_id', '=', 'local_governments.id')
                ->orderBy('id', 'desc')
                ->limit(5)
                ->get();
        return $this->sendApiSuccessResponse($article, "new articles");

    }
    public function article_list(){
        $most_viewed=DB::table('articles')
            ->select(["articles.*", "local_governments.name as localgovernment_name"])
            ->join('local_governments', 'articles.lg_id', '=', 'local_governments.id')
            ->orderBy('viewed', 'desc')
            ->limit(5)
            ->get();
        $most_searched=DB::table('articles')
            ->select(["articles.*", "local_governments.name as localgovernment_name"])
            ->join('local_governments', 'articles.lg_id', '=', 'local_governments.id')
            ->orderBy('searched', 'desc')
            ->limit(5)
            ->get();
        $recent=DB::table('articles')
            ->select(["articles.*", "local_governments.name as localgovernment_name"])
            ->join('local_governments', 'articles.lg_id', '=', 'local_governments.id')
            ->orderBy('id', 'desc')
            ->limit(5)
            ->get();
        $data=compact(['most_viewed', 'most_searched', 'recent']);
        return $this->sendApiSuccessResponse($data, "articles for home page");

    }

    public function single_article(Request $request){
        $article_id=$request->get('article_id');
        $article=DB::table('articles')
                  ->select(["articles.*", "local_governments.name as localgovernment_name", "local_governments.website as source"])
                 ->join('local_governments', 'articles.lg_id', '=', 'local_governments.id')
                 ->where('articles.id', $article_id)
                 ->get();
        $single_article=Article::find($article_id);
        $article_tag=$single_article->tags;
        $related_articles=DB::table('articles')
                       ->select(["articles.*", "local_governments.name as localgovernment_name", "local_governments.website as source"])
                        ->join('local_governments', 'articles.lg_id', '=', 'local_governments.id')
                        ->where('tags', 'LIKE', '%'.$article_tag.'%')
                        ->limit(10)
                        ->get();
        $data=compact('article', 'related_articles');
        return $this->sendApiSuccessResponse($data, "Single article and related articles");

    }


}

