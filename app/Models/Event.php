<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class Event extends Model
{
    protected $fillable = [
        'school_id',
        'created_by',
        'gallery_id',
        'title',
        'description',
        'location_type',
        'target_grade',
        'event_date',
        'status',
        'reminder_days_before'
    ];
    protected $casts = ['event_date' => 'datetime'];

    public function school(): BelongsTo
    {
        return $this->belongsTo(School::class);
    }

    public function creator(): BelongsTo
    {
        return $this->belongsTo(User::class, 'created_by');
    }

    public function gallery(): BelongsTo
    {
        return $this->belongsTo(Gallery::class);
    }
}
