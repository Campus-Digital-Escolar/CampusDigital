<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class OfficialComunication extends Model
{
    protected $table = 'official_comunications';
    protected $fillable = [
        'school_id',
        'created_by',
        'title',
        'category',
        'adjective_emotion',
        'introduction',
        'key_points',
        'closure',
        'requires_signature',
        'signature_path',
        'status'
    ];
    protected $casts = [
        'key_points' => 'array',
        'requires_signature' => 'boolean'
    ];

    public function school(): BelongsTo
    {
        return $this->belongsTo(School::class);
    }

    public function creator(): BelongsTo
    {
        return $this->belongsTo(User::class, 'created_by');
    }
}
