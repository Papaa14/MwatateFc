<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Transaction extends Model
{
    //
    protected $fillable = [
        'external_reference',
        'lipia_reference',
        'phone_number',
        'amount',
        'status',
        'receipt_number',
        'metadata',
    ];

}
