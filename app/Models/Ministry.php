<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Ministry extends Model
{
    use HasFactory;

    protected $table = "ministries";

    protected $primaryKey = "id";


    public function users()
    {
        return $this->hasMany(User::class, 'ministry_id', 'id');
    }
}
