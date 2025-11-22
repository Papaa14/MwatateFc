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
        'venue',        // 'Home' or 'Away'
        'competition',  // e.g., 'League', 'Cup'
    ];

    // Cast match_date to a Carbon instance automatically
    protected $casts = [
        'match_date' => 'datetime',
    ];

    /**
     * A fixture can have many ticket types associated with it.
     */
    public function tickets()
    {
        return $this->hasMany(Ticket::class);
    }
}
