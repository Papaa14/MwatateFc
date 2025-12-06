<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class TeamMessage extends Model
{
    //
    protected $fillable = ['sender_id', 'recipient_group', 'subject', 'content'];
}
