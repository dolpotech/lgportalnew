<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class TemplateField extends Model
{
    use HasFactory;

    protected $fillable = ['template_id', 'name', 'type', 'default', 'is_required', 'options'];

    protected $table = 'template_fields';


    /**
     * The attributes that should be cast.
     *
     * @var array
     */
    protected $casts = [
        'options' => 'array',
    ];

}
