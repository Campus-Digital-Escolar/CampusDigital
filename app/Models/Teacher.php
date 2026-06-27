<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;

class Teacher extends Model
{
    protected $fillable = [
        'user_id',
        'enrollment_number',
        'profession',
        'photo_path'
    ];

    public function user(): BelongsTo
    {
        return $this->belongsTo(User::class);
    }

    public function groupsTeachers(): HasMany
    {
        return $this->hasMany(GroupTeacher::class);
    }

    public function tutoredGroups(): HasMany
    {
        return $this->hasMany(Group::class, 'tutor_id');
    }
}
