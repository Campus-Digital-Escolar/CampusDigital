<?php

namespace App\Http\Controllers\Sports;

use App\Http\Controllers\Controller;
use App\Http\Requests\Sports\MatchStatRecordRequest;
use App\Models\MatchStatRecord;
use App\Traits\ApiResponse;

class MatchStatRecordController extends Controller
{
    use ApiResponse;

    public function store(MatchStatRecordRequest $request)
    {
        $record = MatchStatRecord::updateOrCreate(
            $request->only(['event_id', 'participant_id', 'stat_definition_id']),
            ['value' => $request->input('value')]
        );
        return $this->successResponse($record, 'Rendimiento estadístico guardado');
    }
}
