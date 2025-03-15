<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class Competitor extends Model
{
    use HasFactory;
    
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
