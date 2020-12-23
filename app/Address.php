<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Address extends Model
{
    protected $fillable = ['name', 'address', 'coordinate', 'note', 'customer_id'];
}
