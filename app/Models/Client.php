<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Laravel\Scout\Searchable;

class Client extends Model
{
    use Searchable;

    /** @var array  */
    protected $visible = [
        'id',
        'name',
        'email',
        'phone',
    ];

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
