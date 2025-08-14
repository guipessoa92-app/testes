<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Measurement extends Model
{
    use HasFactory;

    protected $fillable = [
        'user_id',
        'measurement_date',
        'weight',
        'age',
        'sex',
        'shoulders',
        'chest',
        'biceps_right_contracted',
        'biceps_right_relaxed',
        'biceps_left_contracted',
        'biceps_left_relaxed',
        'forearm_right',
        'forearm_left',
        'waist',
        'abdomen',
        'hips',
        'gluteos',
        'thigh_right',
        'thigh_left',
        'calf_right',
        'calf_left',
        'pectorals',
        'midaxillary',
        'triceps',
        'subscapular',
        'abdominal',
        'suprailiac',
        'skinfold_thigh_right',
        'skinfold_thigh_left',
        'notes',
    ];

    protected $casts = [
        'measurement_date' => 'date',
    ];

    public function user()
    {
        return $this->belongsTo(User::class);
    }
}
