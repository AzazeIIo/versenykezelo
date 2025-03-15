<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Relations\HasManyThrough;

class Round extends Model
{
    use HasFactory;

    protected $fillable = [
        'competition_id',
        'round_number',
        'date',
    ];

    public function competitions()
    {
        return $this->belongsTo(Competition::class, 'competition_id');
    }

    public function competitors()
    {
        return $this->hasMany(Competitor::class);
    }

    public function users()
    {
        return $this->through('competitors')->has('users');
    }
}
