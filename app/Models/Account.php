<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Venturecraft\Revisionable\RevisionableTrait;

class Account extends Model
{
    use RevisionableTrait;

    /** @var bool */
    protected $revisionCleanup = true;

    /** @var int  */
    protected $historyLimit = 500;

    /** @var array */
    protected $keepRevisionOf = array(
        'type',
        'credential_login',
        'credential_password',
        'credential_comment'
    );

    /** @var array */
    public static $accounts_type = [
        'ssh'   => 'SSH',
        'ftp'   => 'FTP',
        'mysql' => 'MySQL',
        'admin' => 'Administration',
        'mail'  => 'Mail'
    ];

    /** @var array  */
    protected $visible = [
        'id',
        'type',
        'type_name',
        'credential_login',
        'credential_password',
        'credential_comment',
        'accountable'
    ];

    /** @var array  */
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
        return array_key_exists($this->attributes['type'], self::$accounts_type) ? self::$accounts_type[$this->attributes['type']] : '???';
    }

    /**
     * @return  string
     */
    public function getCredentialLoginAttribute()
    {
        return empty($this->attributes['credential_login']) ? null : decrypt($this->attributes['credential_login']);
    }

    /**
     * @return  string
     */
    public function getCredentialPasswordAttribute()
    {
        return empty($this->attributes['credential_password']) ? null : decrypt($this->attributes['credential_password']);
    }

    /**
     * @return  string
     */
    public function getCredentialCommentAttribute()
    {
        return empty($this->attributes['credential_comment']) ? null : decrypt($this->attributes['credential_comment']);
    }

    /**
     * @return  void
     */
    public function setCredentialLoginAttribute($value)
    {
        $this->attributes['credential_login'] = encrypt($value);
    }

    /**
     * @return  void
     */
    public function setCredentialPasswordAttribute($value)
    {
        $this->attributes['credential_password'] = encrypt($value);
    }

    /**
     * @return  void
     */
    public function setCredentialCommentAttribute($value)
    {
        $this->attributes['credential_comment'] = encrypt($value);
    }
}
