<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Template extends Model
{
    use HasFactory;

    protected $table = 'templates';

    protected $fillable = ['name'];


    /**
     * Fields Relationship
     *
     * @return \Illuminate\Database\Eloquent\Relations\HasMany
     */
    public function fields(): \Illuminate\Database\Eloquent\Relations\HasMany
    {
        return $this->hasMany(TemplateField::class, 'template_id');
    }

}
