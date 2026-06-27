<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;

class Student extends Model
{
    protected $fillable = [
        'user_id',
        'enrollment_number',
        'photo_path',
        'grade_average'
    ];
    protected $casts = [
        'grade_average' => 'decimal:1'
    ];

    public function user(): BelongsTo
    {
        return $this->belongsTo(User::class);
    }

    public function parents(): BelongsToMany
    {
        return $this->belongsToMany(User::class, 'parent_student', 'student_id', 'parent_user_id');
    }

    public function groups(): BelongsToMany
    {
        return $this->belongsToMany(Group::class, 'group_student');
    }

    public function grades(): HasMany
    {
        return $this->hasMany(Grade::class);
    }

    public function diplomas(): HasMany
    {
        return $this->hasMany(StudentDiploma::class);
    }
}
