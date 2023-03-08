<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Spatie\Searchable\Searchable;
use Spatie\Searchable\SearchResult;


class ResourceMap extends Model
{
    use HasFactory;

    protected $table = "resource_maps";
    public function searchType()
    {
        return 'resource_maps';
    }


    public function lg()
    {
        return $this->belongsTo(LocalGovernment::class, 'lg_id');
    }

    public static function searchColumn()
    {
        return ['language', 'title', 'body'];
    }
}
