<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Disk extends Model
{
    /**
     * Mass assignable attributes.
     *
     * @var array
     */
    public $fillable = [
        'device', 'mount_point', 'file_system', 'total', 'used', 'free', 'percent'
    ];

    /**
     * Returns the disk server.
     *
     * @return App\Server
     */
    public function server()
    {
        return $this->belongsTo(Server::class);
    }

    /**
     * Return the disk time.
     *
     * @return App\Time
     */
    public function time()
    {
        return $this->belongsTo(Time::class);
    }
}
