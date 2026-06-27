<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;
class Group extends Model
{
    protected $fillable = [
        'grade',
        'section',
        'educational_level_id',
        'school_year_id',
        'tutor_id',
    ];

    public function educationalLevel(): BelongsTo
    {
        return $this->belongsTo(EducationalLevel::class);
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
