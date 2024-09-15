<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class OrderOutItem extends Model
{
    use HasFactory;

    // Define fillable attributes
    protected $guarded = [

    ];
    public function Thread()
    {
        return $this->belongsTo(Thread::class);
    }
    // OrderOutItem model
public function orderOut()
{
    return $this->belongsTo(OrderOut::class, 'order_out_id');
}

public function party()
{
    return $this->belongsTo(Party::class, 'party_id');
}
public function quality()
    {
        return $this->belongsTo(Quality::class, 'quality_id');
    }
}
