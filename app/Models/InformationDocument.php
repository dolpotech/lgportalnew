<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Spatie\Searchable\Searchable;
use Spatie\Searchable\SearchResult;

class InformationDocument extends Model
{
    use HasFactory;

    protected $table = "documents";

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'info_receiver_id', 'field_id', 'answer', 'main_doc', 'main_doc_type' ,'main_doc_path','supporting_doc',
        'supporting_doc_path', 'supporting_doc_type'
    ];

    protected $appends = ['document_url'];

    /**
     * Get Document Url
     *
     * @return string
     */
    public function getDocumentUrlAttribute()
    {
        return getDocumentStorageUrl();
    }


//    /**
//     * Set the document url.
//     *
//     * @param  string  $value
//     * @return void
//     */
//    public function setMainDocPathAttribute($value)
//    {
//        $this->attributes['main_doc_path'] = getDocumentStorageUrl().$value;
//    }
}
