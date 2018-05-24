<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Address extends Model
{
    /**
     * Mass assignable attributes.
     *
     *@var array
     */
    public $fillable = [
        'name', 'ip'
    ];

    /**
     * Returns the user.
     *
     * @return void
     */
    public function user()
    {
        return $this->belongsTo(Net::class);
    }
}
