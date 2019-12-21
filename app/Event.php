<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Event extends Model
{
    protected $table="events";
    protected $id="id";

    public $timestamps = true;

    public function user()
    {
        return $this->belongsTo('App\User');
    }
}
