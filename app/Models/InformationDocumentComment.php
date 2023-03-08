<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Spatie\Searchable\Searchable;
use Spatie\Searchable\SearchResult;

class InformationDocumentComment extends Model
{
    use HasFactory;

    protected $table = "document_comments";

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'document_id', 'message', 'reply', 'is_resolved'
    ];


}
