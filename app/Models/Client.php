<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Client extends Model
{
    /** @var array  */
    protected $visible = [
        'id',
        'name',
        'email',
        'phone',
    ];

    /**
     * @return  \Illuminate\Database\Eloquent\Relations\HasMany
     */
    public function sites()
    {
        return $this->hasMany(Site::class);
    }
}
