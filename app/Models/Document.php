<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Spatie\Searchable\Searchable;
use Spatie\Searchable\SearchResult;


class Document extends Model
{
    protected $table="lg_documents";


    public function searchType()
    {
        return 'documents';
    }
    use HasFactory;

    public function lg()
    {
        return $this->belongsTo(LocalGovernment::class, 'lg_id');
    }

    public static function searchColumn()
    {
        return ['title', 'body','documents','document_type','image'];
    }
}
