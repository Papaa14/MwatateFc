<?php
// app/Models/TrainingPlanAssignment.php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class TrainingPlanAssignment extends Model
{
    use HasFactory;

    protected $fillable = [
        'training_plan_id',
        'player_id',
        'completed_at'
    ];

    protected $casts = [
        'completed_at' => 'datetime'
    ];

    public function trainingPlan()
    {
        return $this->belongsTo(TrainingPlan::class);
    }

    public function player()
    {
        return $this->belongsTo(User::class, 'player_id');
    }
}
