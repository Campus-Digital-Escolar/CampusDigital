<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;

class AcademicPeriod extends Model
{
    protected $table = 'academic_periods';
    protected $fillable = [
        'school_year_id',
        'name',
        'start_date',
        'end_date',
    ];

    protected $casts = [
        'start_date' => 'date',
        'end_date' => 'date',
    ];

    public function grades(): HasMany
    {
        return $this->hasMany(Grade::class);
    }

    public function studentDiplomas(): HasMany
    {
        return $this->hasMany(StudentDiploma::class);
    }

    public function honorRollOverrides(): HasMany
    {
        return $this->hasMany(HonorRollOverride::class);
    }

    public function schoolYear(): BelongsTo
    {
        return $this->belongsTo(SchoolYear::class);
    }

    public function gradingPeriods(): HasMany
    {
        return $this->hasMany(GradingPeriod::class);
    }
}
