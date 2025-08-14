<?php
namespace App\Models;
use Illuminate\Database\Eloquent\Model;
class DayOfWeek extends Model
{
    public $timestamps = false; // Esta tabela não precisa de timestamps
    protected $fillable = ['name'];

    public function trainings()
    {
        return $this->belongsToMany(Training::class);
    }
}