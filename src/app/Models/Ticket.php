<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Ticket extends Model
{
    use HasFactory;

    protected $fillable = [
        'fixture_id',
        'type',              // e.g., 'VIP', 'Regular'
        'price',
        'quantity_available',
    ];

    /**
     * A ticket belongs to a specific fixture.
     */
    public function fixture()
    {
        return $this->belongsTo(Fixture::class);
    }
}
