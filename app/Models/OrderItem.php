<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class OrderItem extends Model
{
    use HasFactory;
    public $guarded = [];
    public function Thread()
    {
        return $this->belongsTo(Thread::class);
    }
    public function order()
    {
        return $this->belongsTo(Order::class);
    }
    // OrderItem.php
    public function getThreadDateAttribute()
    {
        return $this->attributes['thread_date'] ? \Carbon\Carbon::parse($this->attributes['thread_date']) : null;
    }

}
