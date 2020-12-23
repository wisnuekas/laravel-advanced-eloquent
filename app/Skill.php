<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Skill extends Model
{
    protected $fillable = [ 'name' ];

    public $timestamps = false;

    public function mitras()
    {
        return $this->belongsToMany('App\Mitra');
    }
}
