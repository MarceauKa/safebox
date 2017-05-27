<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Account extends Model
{

    /** @var array */
    public static $accounts_type = [
        'ssh' => 'SSH',
        'ftp' => 'FTP',
        'mysql' => 'MySQL',
        'website' => 'Website',
        'email' => 'Email'
    ];

    /** @var array */
    protected $visible = [
        'id',
        'type',
        'type_name',
        'credentials',
        'accountable'
    ];

    /** @var array */
    protected $appends = ['type_name'];

    /**
     * @return  \Illuminate\Database\Eloquent\Relations\MorphTo
     */
    public function accountable()
    {
        return $this->morphTo();
    }

    /**
     * @return  string
     */
    public function getTypeNameAttribute()
    {
        $type = $this->attributes['type'];
        return array_key_exists($type, self::$accounts_type) ? self::$accounts_type[$this->attributes['type']] : '???';
    }

    /**
     * @return  string
     */
    public function getCredentialsAttribute()
    {
        return empty($this->attributes['credentials']) ? null : json_decode(decrypt($this->attributes['credentials']));
    }

    /**
     * @return  void
     */
    public function setCredentialsAttribute($value)
    {
        $this->attributes['credentials'] = encrypt(json_encode($value));
    }
}
