<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;

class Teacher extends Model
{
    protected $fillable = [
        'user_id',
        'name',
        'lastname',
        'job_position_id',
        'title',
        'profession',
        'photo_path',
        'status',
    ];

    public function user(): BelongsTo
    {
        return $this->belongsTo(User::class);
    }

    public function groupsTeachers(): HasMany
    {
        return $this->hasMany(GroupTeacher::class, 'teacher_id');
    }

    public function tutoredGroups()
    {
        return $this->belongsToMany(Group::class, 'group_tutor', 'tutor_id', 'group_id')
            ->withPivot('academic_period_id', 'school_year_id', 'active')
            ->withTimestamps();
    }

    public function jobPosition()
    {
        return $this->belongsTo(JobPosition::class);
    }
}
