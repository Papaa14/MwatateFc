<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Stadium extends Model
{
    use HasFactory;

    protected $table = 'stadiums';

    protected $fillable = ['name', 'capacity', 'sections_config'];

    protected $casts = [
        'sections_config' => 'array',
    ];

    public function fixtures()
    {
        return $this->hasMany(Fixture::class);
    }

    /**
     * Generate tickets based on sections configuration
     */
    public function generateTickets()
    {
        if (!$this->sections_config || empty($this->sections_config)) {
            return;
        }

        // First, get all fixtures for this stadium
        $fixtures = $this->fixtures()->get();

        foreach ($fixtures as $fixture) {
            // Delete existing tickets for this fixture to avoid duplicates
            $fixture->tickets()->delete();

            // Create new tickets based on sections
            foreach ($this->sections_config as $section) {
                Ticket::create([
                    'fixture_id' => $fixture->id,
                    'type' => $section['name'],
                    'price' => $section['price'] ?? 0,
                    'quantity_available' => $section['seats'] ?? 0,
                ]);
            }
        }
    }
}
