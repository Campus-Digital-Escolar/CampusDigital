<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class GroupGrade extends Model
{
    protected $fillable = [
        'educational_level_id',
        'name',
        'order',
    ];

    public function educationalLevel()
    {
        return $this->belongsTo(EducationalLevel::class);
    }

    public function groups()
    {
        return $this->hasMany(Group::class);
    }
}
