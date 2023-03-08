<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Spatie\Searchable\Searchable;
use Spatie\Searchable\SearchResult;

class Gallery extends Model implements Searchable
{
    use HasFactory;
    public function getSearchResult(): SearchResult
    {
        $url = '';

        return new \Spatie\Searchable\SearchResult(
            $this,
            $this->title,
            $url
        );
    }
    protected $table="galleries";
}
