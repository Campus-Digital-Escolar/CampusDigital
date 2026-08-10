<?php

namespace App\Http\Controllers\Academic;

use App\Http\Controllers\Controller;
use App\Http\Requests\Academic\BulkStoreGradesRequest;
use App\Http\Requests\Academic\GradeRequest;
use App\Http\Resources\Academic\GradeResource;
use App\Models\Grade;
use App\Models\Student;
use App\Traits\ApiResponse;
use Exception;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class GradeController extends Controller
{
    use ApiResponse;

    public function index(Request $request)
    {
        if ($request->has('group_id') || $request->has('subject_id')) {
            $query = Grade::with(['student.user', 'subject', 'academicPeriod', 'schoolYear', 'gradingPeriod']);

            if ($request->filled('group_id')) {
                $studentIds = DB::table('group_student')
                    ->where('group_id', $request->group_id)
                    ->pluck('student_id');

                $query->whereIn('student_id', $studentIds->isNotEmpty() ? $studentIds : [0]);
            }

            $query->when($request->subject_id, function ($q) use ($request) {
                $q->where('subject_id', $request->subject_id);
            });

            $query->when($request->academic_period_id, function ($q) use ($request) {
                $q->where('academic_period_id', $request->academic_period_id);
            })
                ->when($request->grading_period_id, function ($q) use ($request) {
                    $q->where('grading_period_id', $request->grading_period_id);
                });

            $grades = $query->get();

            return $this->successResponse(
                GradeResource::collection($grades),
                'Calificaciones filtradas obtenidas con éxito.'
            );
        }

        return $this->successResponse(
            GradeResource::collection(Grade::with(['student.user', 'subject', 'academicPeriod', 'schoolYear', 'gradingPeriod'])->get())
        );
    }

    public function store(GradeRequest $request)
    {
        $grade = Grade::create(
            [
                'school_id'          => $request->input('school_id'),
                'student_id'         => $request->input('student_id'),
                'subject_id'         => $request->input('subject_id'),
                'academic_period_id' => $request->input('academic_period_id'),
                'school_year_id'     => $request->input('school_year_id'),
                'grading_period_id'  => $request->input('grading_period_id'),
                'score'              => $request->input('score')
            ],
        );
        return $this->successResponse(new GradeResource($grade), 'Calificación asentada con éxito', 201);
    }

    public function update(GradeRequest $request, $id)
    {
        $grade = Grade::findOrFail($id);

        $dataToUpdate = [
            'score' => $request->input('score')
        ];

        $grade->update($dataToUpdate);

        return $this->successResponse(new GradeResource($grade), 'Calificación actualizada con éxito.');
    }

    public function bulkStore(BulkStoreGradesRequest $request)
    {
        $data = $request->validated();

        DB::transaction(function () use ($data) {
            foreach ($data['grades'] as $item) {
                Grade::create([
                    'school_id'          => $data['school_id'],
                    'student_id'         => $item['student_id'],
                    'subject_id'         => $data['subject_id'],
                    'academic_period_id' => $data['academic_period_id'],
                    'school_year_id'     => $data['school_year_id'],
                    'grading_period_id'  => $data['grading_period_id'],
                    'score'              => $item['score']
                ]);
            }
        });

        return $this->successResponse(null, 'Las calificaciones del grupo se guardaron correctamente.');
    }

    public function bulkUpdate(Request $request)
    {
        $data = $request->validate([
            'grades' => 'required|array',
            'grades.*.id' => 'required|integer|exists:grades,id',
            'grades.*.student_id' => 'required|integer|exists:students,id',
            'grades.*.score' => 'required|numeric|min:0|max:10',
        ]);

        DB::transaction(function () use ($data) {
            foreach ($data['grades'] as $item) {
                Grade::where('id', $item['id'])->update([
                    'score' => $item['score']
                ]);
            }
        });

        return $this->successResponse(null, 'Calificaciones masivas actualizadas correctamente.');
    }

    public function summary(Request $request)
    {
        try {
            $groupId = $request->query('group_id');
            $subjectId = $request->query('subject_id');
            $gradingPeriodId = $request->query('grading_period_id');

            $query = Grade::query();

            if ($groupId) {
                $query->whereHas('student', function ($q) use ($groupId) {
                    $q->where('group_id', $groupId);
                });
            }
            if ($subjectId) {
                $query->where('subject_id', $subjectId);
            }
            if ($gradingPeriodId) {
                $query->where('grading_period_id', $gradingPeriodId);
            }

            $stats = $query->select(
                DB::raw('COUNT(id) as total_grades'),
                DB::raw('ROUND(AVG(score), 1) as average_score'),
                DB::raw('SUM(CASE WHEN score >= 6.0 THEN 1 ELSE 0 END) as passed_count'),
                DB::raw('SUM(CASE WHEN score < 6.0 THEN 1 ELSE 0 END) as failed_count')
            )->first();

            $captureProgress = 100;
            if ($groupId) {
                $totalStudents = Student::where('group_id', $groupId)->count();
                if ($totalStudents > 0) {
                    $captureProgress = round(($stats->total_grades / $totalStudents) * 100, 1);
                }
            }

            $summaryData = [
                'total_records'    => (int) $stats->total_grades,
                'general_average'  => $stats->average_score ? (float) $stats->average_score : 0.0,
                'passed'           => (int) $stats->passed_count,
                'failed'           => (int) $stats->failed_count,
                'capture_progress' => $groupId ? $captureProgress : null, // nulo si es global
                'filters_applied'  => [
                    'group_id'          => $groupId ? (int)$groupId : null,
                    'subject_id'        => $subjectId ? (int)$subjectId : null,
                    'grading_period_id' => $gradingPeriodId ? (int)$gradingPeriodId : null,
                ]
            ];

            return $this->successResponse(
                $summaryData,
                'Resumen de calificaciones generado con éxito.'
            );

        } catch (Exception $e) {
            return $this->errorResponse(
                'No se pudo generar el resumen estadístico.',
                500,
                $e->getMessage()
            );
        }
    }
}
