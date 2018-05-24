<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Server extends Model
{
    /**
     * Mass assignable attributes.
     *
     * @var array
     */
    public $fillable = [
        'name', 'os', 'version', 'processor', 'node', 'platform'
    ];

    /**
     * Returns the server user.
     *
     * @return App\User
     */
    public function user()
    {
        return $this->belongsTo(User::class);
    }

    /**
     * Returns the server PIDs.
     *
     * @return App\Pid
     */
    public function pids()
    {
        return $this->hasMany(Pid::class);
    }

    /**
     * Returns the server NET.
     *
     * @return App\Net
     */
    public function nets()
    {
        return $this->hasMany(Net::class);
    }

    /**
     * Returns the server memory.
     *
     * @return App\Mem
     */
    public function mems()
    {
        return $this->hasMany(Mem::class);
    }

    /**
     * Returns the server CPU.
     *
     * @return App\Cpu
     */
    public function cpus()
    {
        return $this->hasMany(Cpu::class);
    }

    /**
     * Returns the server DISK.
     *
     * @return App\Disk
     */
    public function disks()
    {
        return $this->hasMany(Disk::class);
    }
}
