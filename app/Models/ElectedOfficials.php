<?php

namespace App\Models;

use App\HelperClasses\Traits\NepalitoEnglish;
use Illuminate\Database\Eloquent\Casts\Attribute;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Spatie\Searchable\Searchable;
use Spatie\Searchable\SearchResult;


class ElectedOfficials extends Model
{
    use HasFactory, NepalitoEnglish;


    public function searchType()
    {
        return 'elected_officials';
    }

    protected $table="elected_officials";

    protected function phone(): Attribute
    {
        return Attribute::make(function ($value) {
            return $this->nepali_to_english($value);
        });
    }

    public function lg()
    {
        return $this->belongsTo(LocalGovernment::class, 'lg_id');
    }

    public static function searchColumn()
    {
        return ['language', 'title', 'body', 'designation', 'email','phone','section','tenure'];
    }
}
