<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Order extends Model
{
    use HasFactory;

    protected $fillable = [
        'customer_id',
        'product',
        'price',
        'quantity',
        'section_name',
        'seat_numbers',
        'fixture_id',
        'ticket_type',
    ];

    protected $casts = [
        'seat_numbers' => 'array',
    ];

    // Optional: Define relationship to User
    public function customer()
    {
        return $this->belongsTo(User::class, 'customer_id');
    }

    public function fixture()
    {
        return $this->belongsTo(Fixture::class, 'fixture_id');
    }
}
