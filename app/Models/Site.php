<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Laravel\Scout\Searchable;
use Venturecraft\Revisionable\RevisionableTrait;

class Site extends Model
{
    use Searchable, RevisionableTrait;

    /** @var array */
    protected $visible = [
        'id',
        'name',
        'client',
        'url',
        'client_id',
    ];

    /** @var bool */
    protected $revisionCleanup = true;

    /** @var int */
    protected $historyLimit = 20;

    /** @var array */
    protected $keepRevisionOf = array(
        'name',
        'url'
    );

    /**
     * Get the indexable data array for the model.
     *
     * @return array
     */
    public function toSearchableArray()
    {
        return collect($this->toArray())->only(['id', 'name', 'url'])->toArray();
    }
    
    /**
     * @return  \Illuminate\Database\Eloquent\Relations\MorphMany
     */
    public function accounts()
    {
        return $this->morphMany(Account::class, 'accountable');
    }

    /**
     * @return  \Illuminate\Database\Eloquent\Relations\BelongsTo
     */
    public function client()
    {
        return $this->belongsTo(Client::class);
    }
}
