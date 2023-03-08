<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class MinistryOffices extends Model
{
    use HasFactory;

    protected $table = "ministry_offices";

    protected $primaryKey = "id";

    protected $fillable =['name','name_en', 'address', 'phone_no', 'email', 'ministry_id', 'status'];


    public function users()
    {
        return $this->hasMany(User::class, 'office_id', 'id');
    }
}
