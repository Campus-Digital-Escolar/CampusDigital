<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class HonorRollOverride extends Model
{
    protected $table = 'honor_roll_overrides';
    protected $fillable = [
        'school_id', //??
        'school_year_id',
        'academic_period_id',
        'student_id',
        'action',
        'reason',
        'created_by'
    ];
    public $timestamps = false;

    public function schoolYear(): BelongsTo
    {
        return $this->belongsTo(SchoolYear::class);
    }

    public function academicPeriod(): BelongsTo
    {
        return $this->belongsTo(AcademicPeriod::class);
    }

    public function student(): BelongsTo
    {
        return $this->belongsTo(Student::class);
    }

    public function creator(): BelongsTo
    {
        return $this->belongsTo(User::class, 'created_by');
    }
}
