<?php

namespace App\Models;

use Illuminate\Contracts\Auth\MustVerifyEmail;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Laravel\Sanctum\HasApiTokens;

class User extends Authenticatable
{
    use HasApiTokens, HasFactory, Notifiable;

    /**
     * The attributes that are mass assignable.
     *
     * @var array<int, string>
     */
    protected $fillable = [
        'name',
        'address',
        'ministry_id',
        'ministry_department_id',
        'office_id',
        'lg_id',
        'email',
        'password',
        'type',
        'phone_no',
        'status',
    ];

    /**
     * The attributes that should be hidden for serialization.
     *
     * @var array<int, string>
     */
    protected $hidden = [
        'password',
        'remember_token',
    ];

    /**
     * The attributes that should be cast.
     *
     * @var array<string, string>
     */
    protected $casts = [
        'email_verified_at' => 'datetime',
    ];

    public function roles()
    {
        return $this->belongsToMany(Role::class, 'user_roles', 'user_id', 'role_id');
    }

//    public function roles()
//    {
//        return $this->hasMany(Role::class, 'user_id', 'role_id');
//    }

    public function local_government()
    {
        return $this->belongsTo(LocalGovernment::class, 'lg_id');
    }

    public function ministry()
    {
        return $this->belongsTo(Ministry::class, 'ministry_id');
    }

    public function ministry_office()
    {
        return $this->belongsTo(MinistryOffices::class, 'office_id');
    }

    public function ministry_department()
    {
        return $this->belongsTo(MinistryDepartment::class, 'ministry_department_id');
    }


    /*public function ministry_office()
    {
        return $this->belongsTo(Ministry::class, 'ministry_id');
    }*/
}
