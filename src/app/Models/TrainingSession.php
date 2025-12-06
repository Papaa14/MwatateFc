<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class TrainingSession extends Model
{
    //
    protected $fillable = ['date', 'time', 'location', 'type', 'description'];
}
