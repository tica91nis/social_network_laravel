<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Post extends Model
{
    protected $table = "posts"; //ovo se navodi ukoliko je ime modela razlicito od imena tabele u bazi
    protected $id = "id";// ukoliko primarni kljuc nije id

    public $timestamps = true; //ako je true, kolone colone created_at and updated_at se automatski popunjavaju prilikom kreiranja novog reda

    public function user()
    {
        return $this->belongsTo('App\User');
    }
}
