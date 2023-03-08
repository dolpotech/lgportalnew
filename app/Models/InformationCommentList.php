<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class InformationCommentList extends Model
{
    use HasFactory;

    protected $table = 'information_comment_list';

    protected $fillable = [
        'information_comment_id',
        'user_id',
        'message',
    ];


    /**
     * Commenter Relationship
     *
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
     */
    public function commenter()
    {
        return $this->belongsTo(User::class, 'user_id');
    }

}
