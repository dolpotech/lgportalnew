<?php

namespace App\Models;

use App\HelperClasses\Traits\NepalitoEnglish;
use Illuminate\Database\Eloquent\Casts\Attribute;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class EmergencyNumber extends Model
{
    use HasFactory , NepalitoEnglish;
    protected function phone(): Attribute
    {
        return Attribute::make(function ($value) {
            return $this->nepali_to_english($value);
        });
    }
}
