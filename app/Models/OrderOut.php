<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class OrderOut extends Model
{
    use HasFactory;
    public $guarded = [];
    public function OrderItems()
    {
        return $this->hasMany(OrderOutItem::class, 'order_out_id');
    }
    public function Party()
    {
        return $this->belongsTo(Party::class);
    }
}
