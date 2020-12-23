<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Review extends Model
{
    protected $fillable = [ 'rating', 'review', 'order_id', 'mitra_id', 'customer_id' ];

    public function order()
    {
        return $this->belongsTo('App\Order');
    }

    public function mitra()
    {
        return $this->belongsTo('App\Mitra');
    }

    public function customer()
    {
        return $this->belongsTo('App\Customer');
    }
}
