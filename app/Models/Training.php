<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Training extends Model
{
    use HasFactory;

    protected $fillable = [
        'user_id',
        'name',
        'description',
        // A coluna 'day_of_week' foi removida.
    ];

    public function user()
    {
        return $this->belongsTo(User::class);
    }

    public function exercises()
    {
        return $this->hasMany(Exercise::class);
    }

    public function logs()
    {
        return $this->hasMany(TrainingLog::class);
    }

    /**
     * Relação Muitos-para-Muitos com os dias da semana.
     */
    public function daysOfWeek()
    {
        return $this->belongsToMany(DayOfWeek::class);
    }
}