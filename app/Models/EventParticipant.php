<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;

class EventParticipant extends Model
{
    protected $table = 'event_participants';
    protected $fillable = [
        'event_id',
        'student_id',
        'team_id',
        'result_value',
        'is_winner'
    ];
    protected $casts = ['is_winner' => 'boolean'];

    public function event(): BelongsTo
    {
        return $this->belongsTo(SportEvent::class, 'event_id');
    }

    public function student(): BelongsTo
    {
        return $this->belongsTo(Student::class);
    }

    public function team(): BelongsTo
    {
        return $this->belongsTo(SchoolTeam::class, 'team_id');
    }

    public function matchStatRecords(): HasMany
    {
        return $this->hasMany(MatchStatRecord::class, 'participant_id');
    }
}
