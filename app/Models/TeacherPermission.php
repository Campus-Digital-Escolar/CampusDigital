<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class TeacherPermission extends Model
{
    protected $table = 'teacher_permissions';
    protected $fillable = [
        'user_id',
        'module_name',
        'is_visible',
        'can_add',
        'can_edit',
        'can_delete'
    ];
    protected $casts = [
        'is_visible' => 'boolean',
        'can_add' => 'boolean',
        'can_edit' => 'boolean',
        'can_delete' => 'boolean',
    ];

    public function user(): BelongsTo
    {
        return $this->belongsTo(User::class);
    }
}
