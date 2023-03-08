<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Spatie\Searchable\Searchable;
use Spatie\Searchable\SearchResult;

class Service extends Model
{
    use HasFactory;
    protected $table="services";


    public function searchType()
    {
        return 'services';
    }


    public function lg()
    {
        return $this->belongsTo(LocalGovernment::class, 'lg_id');
    }


    public static function searchColumn()
    {
        return ['title', 'language','service_type','service_time','responsible_officer','service_office','service_fee','required_documents', 'related_documents','process', 'body'];
    }
}
