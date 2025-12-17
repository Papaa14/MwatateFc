<?php
// app/Models/TrainingPlan.php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class TrainingPlan extends Model
{
    use HasFactory;

    protected $fillable = [
        'coach_id',
        'subject',
        'type',
        'description',
        'video_url'
    ];

    public function coach()
    {
        return $this->belongsTo(User::class, 'coach_id');
    }

    public function assignments()
    {
        return $this->hasMany(TrainingPlanAssignment::class);
    }

    public function players()
    {
        return $this->belongsToMany(User::class, 'training_plan_assignments', 'training_plan_id', 'player_id')
                    ->withPivot('completed_at')
                    ->withTimestamps();
    }
}
