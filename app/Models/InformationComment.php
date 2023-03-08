<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class InformationComment extends Model
{
    use HasFactory;

    protected $table = 'information_comments';

    protected $fillable = [
        'information_id',
        'commenter_id',
        'comment',
        'reply'
    ];


    /**
     * Commenter Relationship
     *
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
     */
    public function commenter()
    {
        return $this->belongsTo(User::class, 'commenter_id');
    }

    /**
     * information_comment Relationship
     *
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
     */
    public function information_comment()
    {
        return $this->belongsTo(InformationComment::class);
    }
}
