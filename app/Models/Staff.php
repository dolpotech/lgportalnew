<?php

namespace App\Models;

use App\HelperClasses\Traits\NepalitoEnglish;
use Illuminate\Database\Eloquent\Casts\Attribute;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Spatie\Searchable\Searchable;
use Spatie\Searchable\SearchResult;


class Staff extends Model
{
    use HasFactory, NepalitoEnglish;
    protected $table="staffs";
    protected $primaryKey="id";

    public function searchType()
    {
        return 'staffs';
    }
    public function localgov() {
        return $this->belongsTo('App\Models\LocalGovernment');
    }
    protected function phone(): Attribute
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
        return ['language','title', 'body', 'designation','email','phone','photo','section','tenure'];
    }
}
