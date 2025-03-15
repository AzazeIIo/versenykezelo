<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class Competition extends Model
{
    use HasFactory;

    protected $fillable = [
        'name',
        'year',
        'languages',
        'right_ans',
        'wrong_ans',
        'empty_ans',
    ];

    public function rounds() {
        return $this->hasMany(Round::class);
    }
}
