<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class MatchStatRecord extends Model
{
    protected $table = 'match_stat_records';
    protected $fillable = [
        'event_id',
        'participant_id',
        'stat_definition_id',
        'value'
    ];

    public function sportEvent(): BelongsTo
    {
        return $this->belongsTo(SportEvent::class, 'event_id');
    }

    public function participant(): BelongsTo
    {
        return $this->belongsTo(EventParticipant::class, 'participant_id');
    }

    public function statDefinition(): BelongsTo
    {
        return $this->belongsTo(SportStatDefinition::class, 'stat_definition_id');
    }
}
