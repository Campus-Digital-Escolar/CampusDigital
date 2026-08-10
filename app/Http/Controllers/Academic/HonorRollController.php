<?php

namespace App\Http\Controllers\Academic;

use App\Http\Controllers\Controller;
use App\Models\Student;
use Illuminate\Http\Request;

class HonorRollController extends Controller
{
    public function index(Request $request)
    {
        $levelId = $request->input('level_id');
        $academicPeriodId = $request->input('academic_period_id');
        $gradingPeriodId = $request->input('grading_period_id');
        $groupId = $request->input('group_id');

        $query = Student::with([
            'groups.groupGrade.educationalLevel',
            'groups.schoolYear',
            'grades.academicPeriod.gradingPeriods',
            'grades.gradingPeriod',
            'grades.subject',
            'diplomas'
        ]);

        if ($levelId) {
            $query->whereHas('groups.groupGrade', function ($q) use ($levelId) {
                $q->where('educational_level_id', $levelId);
            });
        }

        if ($groupId) {
            $query->whereHas('groups', function ($q) use ($groupId) {
                $q->where('groups.id', $groupId);
            });
        }

        if ($academicPeriodId) {
            $query->whereHas('grades', function ($q) use ($academicPeriodId, $gradingPeriodId) {
                $q->where('academic_period_id', $academicPeriodId);

                if ($gradingPeriodId) {
                    $q->where('grading_period_id', $gradingPeriodId);
                }
            });
        }

        $students = $query->get();

        $formattedData = $students->map(function ($student) use ($levelId, $academicPeriodId, $gradingPeriodId) {
            $filteredGrades = $student->grades->when($academicPeriodId, function ($collection) use ($academicPeriodId) {
                return $collection->where('academic_period_id', $academicPeriodId);
            })->when($gradingPeriodId, function ($collection) use ($gradingPeriodId) {
                return $collection->where('grading_period_id', $gradingPeriodId);
            });

            $calculatedAverage = $filteredGrades->count() > 0
                ? round($filteredGrades->avg('score'), 2)
                : 0.0;

            $group = $student->groups->first(function ($g) use ($levelId) {
                if (!$levelId) return true;
                return $g->groupGrade?->educational_level_id == $levelId;
            }) ?? $student->groups->first();

            $groupGrade = $group?->groupGrade;
            $educationalLevel = $groupGrade?->educationalLevel;

            $periodsData = [];
            $gradesByPeriod = $student->grades->groupBy('academic_period_id');

            foreach ($gradesByPeriod as $periodId => $gradesInPeriod) {
                $academicPeriod = $gradesInPeriod->first()->academicPeriod;
                if (!$academicPeriod) continue;

                $gradesByGradingPeriod = $gradesInPeriod->groupBy('grading_period_id');
                $gradingPeriodsData = [];

                foreach ($gradesByGradingPeriod as $gradingPeriodGpId => $gradesInGp) {
                    $gradingPeriod = $gradesInGp->first()->gradingPeriod;

                    $gradingPeriodsData[] = [
                        'id' => $gradingPeriod?->id,
                        'name' => $gradingPeriod?->name ?? 'General / Sin Parcial',
                        'grades' => $gradesInGp->map(fn($g) => [
                            'id' => $g->id,
                            'score' => (float) $g->score,
                            'subject_id' => $g->subject_id,
                            'subject_name' => $g->subject?->name ?? 'Sin Materia'
                        ])->values()
                    ];
                }

                $periodsData[] = [
                    'id' => $academicPeriod->id,
                    'name' => $academicPeriod->name,
                    'grading_periods' => $gradingPeriodsData
                ];
            }

            return [
                'id' => $student->id,
                'name' => $student->name,
                'last_name' => $student->lastname,
                'gender' => $student->gender,
                'birthday' => $student->birthday,
                'level' => $educationalLevel?->name ?? 'Sin Nivel Asignado',
                'group_id' => $group?->id,
                'grade' => $groupGrade?->name ?? 'Sin Grado',
                'section' => $group?->section ?? 'A',
                'average' => (float) $calculatedAverage,
                'periods' => $periodsData,
                'grades' => $student->grades->map(fn($g) => [
                    'score' => (float) $g->score
                ])->values(),
                'diplomas' => $student->diplomas
            ];
        });

        return response()->json([
            'status' => true,
            'data' => $formattedData
        ]);
    }
}
