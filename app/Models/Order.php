<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Order extends Model
{
    use HasFactory;
    public $guarded = [];

    public function OrderItems()
    {
        return $this->hasMany(OrderItem::class);
    }
    public function Party()
    {
        return $this->belongsTo(Party::class);
    }

}
