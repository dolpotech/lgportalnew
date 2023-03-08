<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Notification extends Model
{
    use HasFactory;

    protected $fillable=['title','description','ministry_id','lg_id','office_id', 'is_custom', 'to_sms', 'to_email','is_processed'];
}
