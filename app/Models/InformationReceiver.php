<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class InformationReceiver extends Model
{
    use HasFactory;

    protected $table = 'info_receivers';

    protected $fillable = [
        'information_id','ministry_id', 'lg_id', 'office_id', 'status', 'is_opened', 'when_opened'
    ];

    public function documents()
    {
        return $this->hasMany(InformationDocument::class, 'info_receiver_id');
    }

}
