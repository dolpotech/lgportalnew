<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class LocalGovernment extends Model
{
    use HasFactory;
    protected $table = "local_governments";
    protected $primaryKey = "id";
    public function staff()
    {
        return $this->hasmany('App\Models\Staff');
    }

    public function pradesh()
    {
        return $this->belongsTo('App\Models\Pradesh');
    }

    public function district()
    {
        return $this->belongsTo('App\Models\District');
    }


    /**
     * Relationship to Users
     *
     * @return \Illuminate\Database\Eloquent\Relations\HasMany
     */
    public function users()
    {
        return $this->hasMany(User::class, 'lg_id', 'id');
    }


    /**
     * Active Lg
     *
     * @param $query
     * @return mixed
     */
    public function scopeActive($query)
    {
        return $query->where('status', 1);
    }
}
