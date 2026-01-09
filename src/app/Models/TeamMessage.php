<?php


namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class TeamMessage extends Model
{
    use HasFactory;

    protected $fillable = [
        'sender_id',
        'receiver_id',
        'recipient_group',
        'content',
        'is_read'
    ];

    protected $casts = [
        'is_read' => 'boolean',
        'created_at' => 'datetime',
        'updated_at' => 'datetime'
    ];

    // Sender relationship
    public function sender()
    {
        return $this->belongsTo(User::class, 'sender_id');
    }

    // Receiver relationship (individual player)
    public function receiver()
    {
        return $this->belongsTo(User::class, 'receiver_id');
    }
}
