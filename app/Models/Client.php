<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Laravel\Scout\Searchable;
use Venturecraft\Revisionable\RevisionableTrait;

class Client extends Model
{
    use Searchable, RevisionableTrait;

    /** @var array  */
    protected $visible = [
        'id',
        'name',
        'email',
        'phone'
    ];

    /** @var bool */
    protected $revisionCleanup = true;

    /** @var int */
    protected $historyLimit = 20;

    /** @var array */
    protected $keepRevisionOf = array(
        'name',
        'phone',
        'email'
    );

    /**
     * Get the indexable data array for the model.
     *
     * @return array
     */
    public function toSearchableArray()
    {
        return collect($this->toArray())->only(['id', 'name', 'phone', 'email'])->toArray();
    }

    /**
     * @return  \Illuminate\Database\Eloquent\Relations\HasMany
     */
    public function sites()
    {
        return $this->hasMany(Site::class);
    }
}
