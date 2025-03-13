<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Competition extends Model
{
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
