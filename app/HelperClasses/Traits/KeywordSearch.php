<?php

namespace App\HelperClasses\Traits;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Request;
use Illuminate\Support\Str;
use ProtoneMedia\LaravelCrossEloquentSearch\Search;
use App\Models\Article;
use App\Models\Contact;
use App\Models\Document;
use App\Models\ElectedOfficials;
use App\Models\ResourceMap;
use App\Models\Service;
use App\Models\Staff;

trait KeywordSearch
{
//    use ArticlesSearch;
    public function keyword_search( $request, $keyword ,$paginationNo,$search_type){
        $types=array();
        DB::enableQueryLog();
        $query = Search::new();

        if($search_type!=null) {
            if(in_array($search_type, ['contacts', 'resource_maps', 'staffs', 'services', 'elected_officials','articles', 'documents'])) {

                $tag = '';

                if($search_type=='contacts'){
                    $query->add($this->getQuery(Contact::class), Contact::searchColumn());
                    $tag = 'contacts';
                }
                if($search_type=='resource_maps'){
                    $query->add($this->getQuery(ResourceMap::class), ResourceMap::searchColumn());
                    $tag = 'resource_maps';
                }
                if($search_type=='staffs'){
                    $query->add($this->getQuery(Staff::class), Staff::searchColumn());
                    $tag = 'staffs';
                }
                if($search_type=='services'){
                    $query->add($this->getQuery(Service::class), Service::searchColumn());
                    $tag = 'services';
                }
                if($search_type=='elected_officials'){
                    $query->add($this->getQuery(ElectedOfficials::class), ElectedOfficials::searchColumn());
                    $tag = 'elected_officials';
                }
                if($search_type=='articles'){
                    $query->add($this->getQuery(Article::class), Article::searchColumn());
                    $tag = 'articles';
                }
                if($search_type=='documents'){
                    $query->add($this->getQuery(Document::class), Document::searchColumn());
                    $tag = 'documents';
                }

                $searchdata = $query->beginWithWildcard()
                    ->endWithWildcard('false')
                    ->dontParseTerm()
                    ->includeModelType()
                    ->paginate($paginationNo)
                    ->search($keyword)
                    ->withQueryString();
                $summary = $this->getSummary($keyword);
                return compact('searchdata', 'summary');
            }
        }

        $searchdata = $query->add($this->getQuery(Contact::class), Contact::searchColumn())
            ->add($this->getQuery(Document::class), Document::searchColumn())
            ->add($this->getQuery(Article::class), Article::searchColumn())
            ->add($this->getQuery(ElectedOfficials::class), ElectedOfficials::searchColumn())
            ->add($this->getQuery(Service::class), Service::searchColumn())
            ->add($this->getQuery(Staff::class), Staff::searchColumn())
            ->add($this->getQuery(ResourceMap::class), ResourceMap::searchColumn())
            ->beginWithWildcard()
            ->endWithWildcard('false')
            ->dontParseTerm()
            ->includeModelType()
            ->paginate($paginationNo)
            ->search($keyword)
            ->withQueryString();

        $summary = $this->getSummary($keyword);

        return compact('searchdata', 'summary');
    }


    public function getSummary($searchKey)
    {
        $query = Search::new();
        $searchdatacount = $query->add($this->getQuery(Contact::class), Contact::searchColumn())
            ->add($this->getQuery(Document::class), Document::searchColumn())
            ->add($this->getQuery(Article::class), Article::searchColumn())
            ->add($this->getQuery(ElectedOfficials::class), ElectedOfficials::searchColumn())
            ->add($this->getQuery(Service::class), Service::searchColumn())
            ->add($this->getQuery(Staff::class), Staff::searchColumn())
            ->add($this->getQuery(ResourceMap::class), ResourceMap::searchColumn())
            ->beginWithWildcard()
            ->endWithWildcard('false')
            ->dontParseTerm()
            ->includeModelType()
            ->search($searchKey);

        $summary = [];
//        $this->article_search($searchdatacount, $searchKey);
        foreach ($searchdatacount->pluck('type')->unique() as $search_type) {
            $model = $this->getModalByTableName($search_type);
            $count = Search::add($model, ($model)::searchColumn())
                ->beginWithWildcard()
                ->endWithWildcard('false')
                ->dontParseTerm()
                ->search($searchKey)
                ->count();

            $summary[] = [
                'total' => $count,
                'tag'   => $search_type,
                'name'  => Str::headline($search_type),
            ];
        }


        return $summary;
    }


    public function getQuery($class)
    {
        return $class::with('lg');
    }


    public function getModalByTableName($tableName)
    {
        if ($tableName == 'articles') {
            return Article::class;
        }
        if ($tableName == 'contacts') {
            return Contact::class;
        }
        if ($tableName == 'resource_maps') {
            return ResourceMap::class;
        }
        if ($tableName == 'staffs') {
            return Staff::class;
        }
        if ($tableName == 'services') {
            return Service::class;
        }
        if ($tableName == 'elected_officials') {
            return ElectedOfficials::class;
        }
        if ($tableName == 'documents') {
            return Document::class;
        }
        return '';
    }


}
