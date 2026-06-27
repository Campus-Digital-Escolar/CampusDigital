<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class MatchEvent extends Model
{
    protected $table = 'match_events';
    protected $fillable = [
        'event_id',
        'student_id',
        'stat_definition_id',
        'match_time',
        'description'
    ];

    public function sportEvent(): BelongsTo
    {
        return $this->belongsTo(SportEvent::class, 'event_id');
    }

    public function student(): BelongsTo
    {
        return $this->belongsTo(Student::class);
    }

    public function statDefinition(): BelongsTo
    {
        return $this->belongsTo(SportStatDefinition::class, 'stat_definition_id');
    }
}
