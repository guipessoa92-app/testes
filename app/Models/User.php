<?php

namespace App\Models;

// use Illuminate\Contracts\Auth\MustVerifyEmail;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Laravel\Sanctum\HasApiTokens;

class User extends Authenticatable
{
    use HasApiTokens, HasFactory, Notifiable;

    /**
     * The attributes that are mass assignable.
     *
     * @var array<int, string>
     */
    protected $fillable = [
        'name',
        'email',
        'password',
        'dashboard_metric',
        'role',          // <-- ADICIONADO
        'personal_id',   // <-- ADICIONADO
    ];

    /**
     * The attributes that should be hidden for serialization.
     *
     * @var array<int, string>
     */
    protected $hidden = [
        'password',
        'remember_token',
    ];

    /**
     * The attributes that should be cast.
     *
     * @var array<string, string>
     */
    protected $casts = [
        'email_verified_at' => 'datetime',
        'password' => 'hashed',
    ];

    // --- RELAÇÕES EXISTENTES (PRESERVADAS) ---

    public function trainings()
    {
        return $this->hasMany(Training::class);
    }

    public function measurements()
    {
        return $this->hasMany(Measurement::class);
    }

    public function trainingLogs()
    {
        return $this->hasMany(TrainingLog::class);
    }

    // =========================================================================
    // == NOVAS RELAÇÕES ADICIONADAS PARA PERSONAL / ALUNO ==
    // =========================================================================

    /**
     * Relação: Um aluno pertence a um personal.
     */
    public function personal()
    {
        return $this->belongsTo(User::class, 'personal_id');
    }

    /**
     * Relação: Um personal pode ter muitos alunos.
     */
    public function alunos()
    {
        return $this->hasMany(User::class, 'personal_id');
    }

    /**
     * Check if the user has a specific role.
     *
     * @param string $role
     * @return bool
     */
    public function hasRole(string $role): bool
    {
        return $this->role === $role;
    }
}