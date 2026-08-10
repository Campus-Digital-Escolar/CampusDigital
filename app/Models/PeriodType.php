<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class PeriodType extends Model
{
    protected $fillable = [
        'name',
    ];

    public function academicPeriods()
    {
        return $this->hasMany(AcademicPeriod::class);
    }
}
