<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;

class OfficialCommunication extends Model
{
    protected $table = 'official_communications';
    protected $fillable = [
        'school_id',
        'created_by',
        'title',
        'category',
        'adjective_emotion_id',
        'body',
        'signed_by',
        'requires_signature',
        'signature_snapshot_path',
        'status'
    ];
    protected $casts = [
        'requires_signature' => 'boolean'
    ];

    public function attachments(): HasMany
    {
        return $this->hasMany(OfficialCommunicationAttachment::class, 'official_communication_id');
    }

    public function adjectiveEmotion(): BelongsTo
    {
        return $this->belongsTo(PostTagCatalog::class, 'adjective_emotion_id');
    }

    public function school(): BelongsTo
    {
        return $this->belongsTo(School::class);
    }

    public function creator(): BelongsTo
    {
        return $this->belongsTo(User::class, 'created_by');
    }

    public function signer(): BelongsTo
    {
        return $this->belongsTo(User::class, 'signed_by');
    }
}
