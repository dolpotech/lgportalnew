<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class MinistryDepartment extends Model
{
    use HasFactory;

    protected $table = "ministry_departments";

    protected $primaryKey = "id";


    public function users()
    {
        return $this->hasMany(User::class, 'ministry_department_id', 'id');
    }
}
