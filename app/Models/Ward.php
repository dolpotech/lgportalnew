<?php

namespace App\Models;

use App\HelperClasses\Traits\NepalitoEnglish;
use Illuminate\Database\Eloquent\Casts\Attribute;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Spatie\Searchable\Searchable;
use Spatie\Searchable\SearchResult;

class Ward extends Model implements Searchable
{
    use HasFactory, NepalitoEnglish;
    protected $table="wards";
    public function getSearchResult(): SearchResult
    {
        $url = '';

        return new \Spatie\Searchable\SearchResult(
            $this,
            $this->title,
            $url
        );
    }
    protected function phone(): Attribute
    {
        return Attribute::make(function ($value) {
            return $this->nepali_to_english($value);
        });
    }
}
