<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Fixture extends Model
{
    use HasFactory;

    protected $fillable = [
        'opponent',
        'match_date',
        'venue',
        'competition',
        'stadium_id',
        'ticket_capacity',
        'tickets_sold',
    ];

    protected $casts = [
        'match_date' => 'datetime',
    ];

    public function tickets()
    {
        return $this->hasMany(Ticket::class);
    }

    public function stadium()
    {
        return $this->belongsTo(Stadium::class);
    }

    public function hasAvailableTickets($quantity = 1)
    {
        if (!$this->ticket_capacity) return true;
        return ($this->tickets_sold + $quantity) <= $this->ticket_capacity;
    }

    public function remainingTickets()
    {
        if (!$this->ticket_capacity) return null;
        return max(0, $this->ticket_capacity - $this->tickets_sold);
    }
}
