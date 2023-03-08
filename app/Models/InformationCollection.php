<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Casts\Attribute;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class InformationCollection extends Model
{
    use HasFactory;

    protected $table = 'information_collection';

    protected $fillable = [
        'title',
        'assigner_id',
        'type',
        'agency_type',
        'template_id',
        'main_doc',
        'main_doc_path',
        'main_doc_type',
        'supporting_doc',
        'supporting_doc_path',
        'supporting_doc_type',
        'document_type',
        'submission_date',
        'start_date',
        'status',
        'description',
        'priority'
    ];

    protected $appends = ['information_url'];

    /**
     * Comments Relationship
     *
     * @return \Illuminate\Database\Eloquent\Relations\HasMany
     */
    public function comments(): \Illuminate\Database\Eloquent\Relations\HasMany
    {
        return $this->hasMany(InformationComment::class, 'information_id');
    }


    /**
     * Template Relationship
     *
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
     */
    public function template(): \Illuminate\Database\Eloquent\Relations\BelongsTo
    {
        return $this->belongsTo(Template::class, 'template_id', 'id');
    }


    /**
     * Local Government Relationship
     *
     * @return \Illuminate\Database\Eloquent\Relations\BelongsToMany
     */
    public function local_government()
    {
        return $this->belongsToMany(LocalGovernment::class, 'info_receivers', 'information_id', 'lg_id');
    }


    /**
     * Ministry Relationship
     *
     * @return \Illuminate\Database\Eloquent\Relations\BelongsToMany
     */
    public function ministries(): \Illuminate\Database\Eloquent\Relations\BelongsToMany
    {
        return $this->belongsToMany(Ministry::class, 'info_receivers', 'information_id', 'ministry_id');
    }


    /**
     * Ministry Offices Relationship
     *
     * @return \Illuminate\Database\Eloquent\Relations\BelongsToMany
     */
    public function ministryOffices(): \Illuminate\Database\Eloquent\Relations\BelongsToMany
    {
        return $this->belongsToMany(MinistryOffices::class, 'info_receivers', 'information_id', 'office_id');
    }


    /**
     * Creator Relationship
     *
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
     */
    public function creator(): \Illuminate\Database\Eloquent\Relations\BelongsTo
    {
        return $this->belongsTo(User::class, 'assigner_id', 'id');
    }


    /**
     * Get Document Url
     *
     * @return string
     */
    public function getInformationUrlAttribute()
    {
        return getInformationStorageUrl();
    }

}
