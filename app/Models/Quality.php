<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Quality extends Model
{
    use HasFactory;
    public $guarded = [];
    public function Party()
    {
        return $this->belongsTo(Party::class, 'party_id', 'id');
    }
    public function orderOutItems()
    {
        return $this->hasMany(OrderOutItem::class, 'quality_id');
    }
}
