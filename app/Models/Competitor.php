<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Competitor extends Model
{
    protected $fillable = [
        'user_id',
        'round_id'
    ];

    public function users() {
        return $this->belongsTo(User::class, 'user_id');
    }
    
    public function rounds() {
        return $this->belongsTo(Round::class, 'round_id');
    }
}
