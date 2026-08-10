<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class OfficialCommunicationAttachment extends Model
{
    protected $table = 'official_communication_attachments';

    protected $fillable = [
        'official_communication_id',
        'file_path',
        'file_name',
        'mime_type',
        'file_size',
    ];

    protected $casts = [
        'file_size' => 'integer',
    ];

    public function communication(): BelongsTo
    {
        return $this->belongsTo(OfficialCommunication::class, 'official_communication_id');
    }
}
