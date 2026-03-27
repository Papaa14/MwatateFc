<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class PlayerStat extends Model
{
    use HasFactory;

    protected $fillable = [
        'user_id',
        'season',
        'club_name',
        'appearances',
        'goals',
        'assists',
        'yellow_cards',
        'red_cards',
        'minutes_played'
    ];

    public function user()
    {
        return $this->belongsTo(User::class);
    }
}
