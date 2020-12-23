<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Carbon;

class Order extends Model
{
    protected $fillable = [
        'name',  'description', 'location', 
        'sex_preference', 'max_fee', 'min_fee', 
        'payment_method', 'total', 'canceled_reason',
        'custom', 'category_id', 'customer_id', 
        'mitra_id', 'processed_at', 'finished_at',
        'canceled_at'
    ];

    public function mitra()
    {
        return $this->belongsTo('App\Mitra');
    }

    public function customer()
    {
        return $this->belongsTo('App\Customer');
    }

    public function review()
    {
        return $this->hasOne('App\Review');
    }

    public function getCreatedAtAttribute()
    {
        return Carbon::parse($this->attributes['created_at'])->format('d M Y H:i');
    }

    public function getUpdatedAtAttribute()
    {
        return Carbon::parse($this->attributes['updated_at'])->format('d M Y H:i');
    }

    public function getProcessedAtAttribute()
    {
        return Carbon::parse($this->attributes['processed_at'])->format('d M Y H:i');
    }

    public function getFinishedAtAttribute()
    {
        return Carbon::parse($this->attributes['finished_at'])->format('d M Y H:i');
    }

    public function getCanceledAtAttribute()
    {
        return Carbon::parse($this->attributes['canceled_at'])->format('d M Y H:i');
    }
}
