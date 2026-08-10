<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;
class Group extends Model
{
    protected $fillable = [
        'group_grade_id',
        'section',
        'sch'
    ];

    public function groupGrade(): BelongsTo
    {
        return $this->belongsTo(GroupGrade::class, 'group_grade_id');
    }

    public function students(): BelongsToMany
    {
        return $this->belongsToMany(Student::class, 'group_student')->withPivot('school_year_id');
    }

    public function tutor(): BelongsTo
    {
        return $this->belongsTo(Teacher::class, 'tutor_id');
    }

    public function schoolYear(): BelongsTo
    {
        return $this->belongsTo(SchoolYear::class);
    }
}
