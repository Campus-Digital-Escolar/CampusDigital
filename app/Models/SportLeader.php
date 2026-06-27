<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class SportLeader extends Model
{
    protected $table = 'sport_leaders';
    protected $fillable = [
        'sport_id',
        'student_id',
        'statistic_type',
        'statistic_value'
    ];

    public function sport(): BelongsTo
    {
        return $this->belongsTo(Sport::class);
    }

    public function student(): BelongsTo
    {
        return $this->belongsTo(Student::class);
    }
}
