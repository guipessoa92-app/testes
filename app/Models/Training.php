<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Training extends Model
{
    use HasFactory;

    // Define os campos que podem ser preenchidos em massa
    protected $fillable = [
        'user_id',
        'name',
        'description',
        'day_of_week',
    ];

    // Relação: Um treino pertence a um usuário
    public function user()
    {
        return $this->belongsTo(User::class);
    }

    // Relação: Um treino tem muitos exercícios
    public function exercises()
    {
        return $this->hasMany(Exercise::class);
    }

    /**
     * Relação: Um treino pode ter muitos registros de conclusão (logs).
     */
    public function logs()
    {
        return $this->hasMany(TrainingLog::class);
    }
}