<?php

namespace App\Models;

use App\HelperClasses\Traits\NepalitoEnglish;
use Illuminate\Database\Eloquent\Casts\Attribute;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Spatie\Searchable\Searchable;
use Spatie\Searchable\SearchResult;

class Contact extends Model
{
    use HasFactory, NepalitoEnglish;
    protected $table="contacts";
    public function searchType()
    {
        return 'contacts';
    }



    /**
     * Get the user's first name.
     *
     * @return \Illuminate\Database\Eloquent\Casts\Attribute
     */
    protected function telephone(): Attribute
    {
        return Attribute::make(function ($value) {
            return $this->nepali_to_english($value);
        });
    }

    public function lg()
    {
        return $this->belongsTo(LocalGovernment::class, 'lg_id');
    }


    public static function searchColumn()
    {
        return ['title','address','telephone','email','latitude', 'longitude'];
    }
}
