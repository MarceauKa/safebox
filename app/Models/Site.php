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
        'screenshot_url',
    ];

    /** @var array */
    protected $appends = [
        'screenshot_url'
    ];

    /** @var bool */
    protected $revisionCleanup = true;

    /** @var int */
    protected $historyLimit = 20;

    /** @var array */
    protected $keepRevisionOf = [
        'name',
        'url'
    ];

    /**
     * Get the indexable data array for the model.
     *
     * @return array
     */
    public function toSearchableArray()
    {
        return collect($this->toArray())->only([
            'id',
            'name',
            'url'
        ])->toArray();
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

    /**
     * @return string
     */
    protected function getScreenshotUrlAttribute()
    {
        return url($this->getScreenshotFileAttribute());
    }

    /**
     * @return  string
     */
    protected function getScreenshotFileAttribute()
    {
        $id = $this->attributes['id'];

        return 'screenshots/' . $this->attributes['id'] . '-' . sha1($id) . '.jpg';
    }
}
