<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Exercise extends Model
{
    use HasFactory;

    /**
     * The attributes that are mass assignable.
     *
     * @var array<int, string>
     */
    protected $fillable = [
        'training_id',
        'name',
        'sets',
        'reps',
        'load',
        'notes',
        'order',
    ];

   
    /**
     * Get the training that owns the exercise.
     */
    public function training()
    {
        return $this->belongsTo(Training::class);
    }
}