<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class SchoolCalendar extends Model
{
    protected $table = 'school_calendar';
    protected $fillable = [
        'school_id',
        'title',
        'description',
        'start_date',
        'end_date',
        'type',
        'icon_marker'
    ];

    protected $casts = [
        'start_date' => 'datetime',
        'end_date' => 'datetime'
    ];

    public function school(): BelongsTo
    {
        return $this->belongsTo(School::class);
    }
}
