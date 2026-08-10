<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;

class InternalCommunication extends Model
{
    protected $table = 'internal_communications';
    protected $fillable = [
        'school_id',
        'created_by',
        'category',
        'status',
        'title',
        'description',
        'event_date',
        'location',
        'send_reminder',
        'notes',
    ];
    protected $casts = [
        'event_date' => 'datetime',
        'send_reminder' => 'boolean'
    ];

    public function school(): BelongsTo
    {
        return $this->belongsTo(School::class);
    }

    public function creator(): BelongsTo
    {
        return $this->belongsTo(User::class, 'created_by');
    }

    public function users(): BelongsToMany
    {
        return $this->belongsToMany(User::class, 'internal_communication_user', 'internal_communication_id', 'user_id')
            ->withPivot('notes')
            ->withTimestamps();
    }

}
