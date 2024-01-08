<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Thread extends Model
{
    use HasFactory;
    public $guarded = [];

    public function Party()
    {
        return $this->belongsTo(Party::class, 'party_id', 'id');
    }
}
