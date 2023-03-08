<?php

namespace App\HelperClasses\Traits;

use App\Models\Article;
use App\Models\Contact;
use App\Models\Document;
use App\Models\ElectedOfficials;
use App\Models\ElectedProfile;
use App\Models\Gallery;
use App\Models\ImportantPlaces;
use App\Models\Introduction;
use App\Models\LocalGovernment;
use App\Models\ResourceMap;
use App\Models\Service;
use App\Models\Slider;
use App\Models\Staff;
use App\Models\Ward;
use App\Models\WardOfficials;
use Illuminate\Support\Facades\DB;
use Spatie\Searchable\ModelSearchAspect;
use Spatie\Searchable\Search;

trait Searchtext
{
    public function search_text($request, $keyword, $paginationNo, $search_type)
    {
     DB::enableQueryLog();

        $article_ids = [];
        $type = [];
        $summary = [];
        $source=[];
        $searchResults = (new Search())
            ->registerModel(Contact::class, function (ModelSearchAspect $modelSearchAspect) use ($paginationNo) {
                $modelSearchAspect
                    ->addSearchableAttribute('title')
                    ->addSearchableAttribute('address')
                    ->addSearchableAttribute('telephone')
                    ->addSearchableAttribute('email')
                    ->addSearchableAttribute('latitude')
                    ->addSearchableAttribute('longitude');

            })
            ->registerModel(Document::class, function (ModelSearchAspect $modelSearchAspect) use ($paginationNo) {
                $modelSearchAspect
                    ->addSearchableAttribute('title')
                    ->addSearchableAttribute('body')
                    ->addSearchableAttribute('documents')
                    ->addSearchableAttribute('document_type')
                    ->addSearchableAttribute('image');

            })
            ->registerModel(Article::class, function (ModelSearchAspect $modelSearchAspect) use ($paginationNo) {
                $modelSearchAspect
                    ->addSearchableAttribute('title')
                    ->addSearchableAttribute('tags')
                    ->addSearchableAttribute('body')
                    ->addSearchableAttribute('image')
                    ->addSearchableAttribute('supporting_documents');

            })
            ->registerModel(ElectedOfficials::class, function (ModelSearchAspect $modelSearchAspect) use ($paginationNo) {
                $modelSearchAspect
                    ->addSearchableAttribute('language')
                    ->addSearchableAttribute('title')
                    ->addSearchableAttribute('body')
                    ->addSearchableAttribute('designation')
                    ->addSearchableAttribute('email')
                    ->addSearchableAttribute('phone')
                    ->addSearchableAttribute('section')
                    ->addSearchableAttribute('tenure');

            })



            ->registerModel(Service::class, function (ModelSearchAspect $modelSearchAspect) use ($paginationNo) {
                $modelSearchAspect
                    ->addSearchableAttribute('title')
                    ->addSearchableAttribute('language')
                    ->addSearchableAttribute('service_type')
                    ->addSearchableAttribute('service_time')
                    ->addSearchableAttribute('responsible_officer')
                    ->addSearchableAttribute('service_office')
                    ->addSearchableAttribute('service_fee')
                    ->addSearchableAttribute('required_documents')
                    ->addSearchableAttribute('related_documents')
                    ->addSearchableAttribute('process')
                    ->addSearchableAttribute('body');

            })

            ->registerModel(Staff::class, function (ModelSearchAspect $modelSearchAspect) use ($paginationNo) {
                $modelSearchAspect
                    ->addSearchableAttribute('language')
                    ->addSearchableAttribute('title')
                    ->addSearchableAttribute('body')
                    ->addSearchableAttribute('designation')
                    ->addSearchableAttribute('email')
                    ->addSearchableAttribute('phone')
                    ->addSearchableAttribute('photo')
                    ->addSearchableAttribute('post_box')
                    ->addSearchableAttribute('section')
                    ->addSearchableAttribute('tenure');

            })
            ->registerModel(ResourceMap::class, function (ModelSearchAspect $modelSearchAspect) use ($paginationNo) {
                $modelSearchAspect
                    ->addSearchableAttribute('language')
                    ->addSearchableAttribute('title')
                    ->addSearchableAttribute('body');

            })
            ->search($keyword);

        if($searchResults->count()==0){
            $searchdata="No data found";
            $summary[] = [
                'total' => 0,
                'tag'=> 0,
                'name'=>0,

            ];
            $data=compact('searchdata', 'summary');
            return $data;
        }
        foreach ($searchResults as $searchResult){
            $lgid=$searchResult->searchable['lg_id'];
            $localgovernment=LocalGovernment::find($lgid);
            $searchResult->source=$localgovernment->name;
            $searchResult->website_link=$localgovernment->website;
        }


        foreach ($searchResults as $searchResult) {
            if ($searchResult->type == "articles") {
                $article_ids[] = $searchResult->searchable['id'];

            }
        }
        if (count($article_ids) > 0) {
                foreach ($article_ids as $article_id) {
                    $article = Article::find($article_id);
                    $initial_search = $article->searched;
                    $article->searched = $initial_search + 1;
                    $article->save();
                }
            }
        foreach ($searchResults->groupByType() as $type => $modelSearchResults) {
            $types[] = $type;
        }
        $count = sizeof($types);
        for ($i = 0; $i < $count; $i++) {
            $summary[] = [
                'total' => $searchResults->where('type', $types[$i])->count(),
                'tag'=> $types[$i],
                'name'=>ucwords(str_ireplace('_', ' ', $types[$i])),

            ];
        }


//        $searchdata->setCollection($searchdata->getCollection()->groupBy('type'));
          if($search_type!=null){
                if(in_array($search_type, $types)){
                  $searchdata=$searchResults->where('type', $search_type);
                    $searchdata = collect($searchdata)->paginate($paginationNo)->appends($request->query());
                }
                else{
                    $searchdata="No data found";
                }
          }
          else{
              $searchdata = collect($searchResults)->paginate($paginationNo)->appends($request->query());

          }


        $data=compact('searchdata', 'summary');
            return $data;

        }

    }
