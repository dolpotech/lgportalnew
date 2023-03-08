<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Spatie\Searchable\Searchable;
use Spatie\Searchable\SearchResult;

class DocumentComment extends Model
{
    use HasFactory;

    protected $table = "document_comments";

    protected $fillable = [
        'document_id', 'message', 'reply', 'is_replied'
    ];


}
