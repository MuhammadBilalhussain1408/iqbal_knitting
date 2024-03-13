<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class OrderOutItem extends Model
{
    use HasFactory;
    public $guarded=[];
    public function Thread()
    {
        return $this->belongsTo(Thread::class);
    }
}
