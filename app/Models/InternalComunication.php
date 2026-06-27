<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;

class InternalComunication extends Model
{
    protected $table = 'internal_comunications';
    protected $fillable = [
        'school_id',
        'created_by',
        'category',
        'title',
        'description',
        'event_date',
        'location',
        'send_reminder',
        'approval_status',
        'rerejection_reason'
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
        return $this->belongsToMany(User::class, 'internal_comunication_user');
    }
}
