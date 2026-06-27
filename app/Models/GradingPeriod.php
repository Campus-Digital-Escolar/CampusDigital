<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class GradingPeriod extends Model
{
    protected $table = 'grading_periods';

    protected $fillable = [
        'academic_period_id',
        'name',
        'start_date',
        'end_date',
    ];

    protected $casts = [
        'start_date' => 'date',
        'end_date' => 'date',
    ];

    public function academicPeriod(): BelongsTo
    {
        return $this->belongsTo(AcademicPeriod::class);
    }

    public function isOpenForCapture(): bool
    {
        $now = now();
        return $now->between($this->start_capture_date, $this->end_capture_date);
    }
}
