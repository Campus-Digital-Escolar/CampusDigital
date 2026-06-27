<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class SportTeamRanking extends Model
{
    protected $table = 'sport_team_rankings';
    protected $fillable = [
        'school_id',
        'sport_id',
        'school_year_id',
        'team_id',
        'games_played',
        'games_won',
        'games_drawn',
        'games_lost',
        'points',
        'goals_for',
        'goals_against'
    ];

    public function school(): BelongsTo
    {
        return $this->belongsTo(School::class);
    }

    public function sport(): BelongsTo
    {
        return $this->belongsTo(Sport::class);
    }

    public function schoolYear(): BelongsTo
    {
        return $this->belongsTo(SchoolYear::class);
    }

    public function schoolTeam(): BelongsTo
    {
        return $this->belongsTo(SchoolTeam::class, 'team_id');
    }
}
