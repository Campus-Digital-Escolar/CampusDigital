<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class GradingPeriodType extends Model
{
    protected $fillable = [
        'name',
    ];

    public function gradingPeriods()
    {
        return $this->hasMany(GradingPeriod::class);
    }
}
