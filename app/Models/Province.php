<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use App\Models\LocalGovernment;

class Province extends Model
{
    use HasFactory;

    /**
     * The table associated with the model.
     *
     * @var string
     */
    protected $table = 'provinces';


    /**
     * @var mixed
     */

    public function lg(){
        return $this->hasMany(LocalGovernment::class);
    }
    public function district(){
        return $this->hasMany('App\Models\District');
    }


}
