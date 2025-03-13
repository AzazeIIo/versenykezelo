<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Round extends Model
{
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
}
