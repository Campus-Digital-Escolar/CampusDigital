<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class GradingPeriod extends Model
{
    protected $table = 'grading_periods';

    protected $fillable = [
        'academic_period_id',
        'grading_period_type_id',
        'name',
        'order',
        'start_date',
        'end_date',
        'weight',
        'status',
    ];

    protected $casts = [
        'start_date' => 'date',
        'end_date' => 'date',
        'weight' => 'decimal:2',
    ];

    public function academicPeriod(): BelongsTo
    {
        return $this->belongsTo(AcademicPeriod::class);
    }

    public function gradingPeriodType()
    {
        return $this->belongsTo(GradingPeriodType::class);
    }

    public function isOpenForCapture(): bool
    {
        $now = now();

        return $now->between($this->start_date, $this->end_date);
    }
}
