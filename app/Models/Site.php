<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Site extends Model
{
    /** @var array */
    protected $visible = [
        'id',
        'name',
        'client',
        'url',
        'client_id',
    ];
    
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
