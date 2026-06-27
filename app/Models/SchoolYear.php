<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;

class SchoolYear extends Model
{
    protected $table = 'school_years';
    protected $fillable = [
        'name',
        'start_date',
        'end_date',
        'active',
    ];
    protected $casts = [
        'start_date' => 'date',
        'end_date' => 'date',
        'active' => 'boolean'
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

    public function sportEventTeamRankings(): HasMany
    {
        return $this->hasMany(SportTeamRanking::class);
    }

    public function academicPeriods(): HasMany
    {
        return $this->hasMany(AcademicPeriod::class);
    }
}
