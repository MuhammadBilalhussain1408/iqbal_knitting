<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class OrderOut extends Model
{
    use HasFactory;

    // Define fillable attributes if using the fill method
    protected $fillable = [
        'order_date',
        'party_id',
        'quality_date', 
        'page_no',      
        'quality_id',   
        'num_of_rolls', 
        'total_weight', 
        'order_by'
    ];

    // Define relationships
    public function orderItems()
    {
        return $this->hasMany(OrderOutItem::class, 'order_out_id');
    }

    public function party()
    {
        return $this->belongsTo(Party::class, 'party_id');
    }
}
