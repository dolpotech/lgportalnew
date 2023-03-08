<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Spatie\Searchable\Searchable;
use Spatie\Searchable\SearchResult;


class Article extends Model
{
    use HasFactory;

    protected $table = "articles";


    public function searchType()
    {
        return 'articles';
    }

    /**
     * Get Total
     *
     * @param $query
     * @return mixed
     */
    public function scopeTotal($query)
    {
        return $query->addSelect('COUNT(*) as total');
    }

    public function lg()
    {
        return $this->belongsTo(LocalGovernment::class, 'lg_id');
    }


    public static function searchColumn()
    {
        return ['title','tags','body','image','supporting_documents'];
    }
}
