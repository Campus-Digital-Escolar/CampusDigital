<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Http\Requests\Admin\StudentRequest;
use App\Http\Resources\Admin\StudentResource;
use App\Models\AcademicPeriod;
use App\Models\GradingPeriod;
use App\Models\Group;
use App\Models\SchoolYear;
use App\Models\Student;
use App\Models\StudentDiploma;
use App\Models\User;
use App\Traits\ApiResponse;
use Exception;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Str;

class StudentController extends Controller
{
    use ApiResponse;

    public function index()
    {
        try {
            $students = Student::leftJoin('group_student', 'students.id', '=', 'group_student.student_id')
                ->leftJoin('groups', 'group_student.group_id', '=', 'groups.id')
                ->leftJoin('group_grades', 'groups.group_grade_id', '=', 'group_grades.id')
                ->leftJoin('educational_levels', 'group_grades.educational_level_id', '=', 'educational_levels.id')
                ->orderBy(DB::raw("CASE
                WHEN LOWER(educational_levels.name) LIKE '%preescolar%' THEN 1
                WHEN LOWER(educational_levels.name) LIKE '%primaria%' THEN 2
                WHEN LOWER(educational_levels.name) LIKE '%secundaria%' THEN 3
                WHEN LOWER(educational_levels.name) LIKE '%preparatoria%' THEN 4
                ELSE 5
            END"), 'ASC')
                ->orderBy('group_grades.name', 'ASC')
                ->orderBy('groups.section', 'ASC')
                ->orderBy('students.lastname', 'ASC')
                ->select('students.*')
                ->with(['groups.groupGrade.educationalLevel', 'parents', 'user'])
                ->get();

            return $this->successResponse(StudentResource::collection($students), "Listado de alumnos obtenido con éxito.");
        } catch (Exception $e) {
            return $this->errorResponse("Error al obtener el listado de alumnos", 500, $e->getMessage());
        }
    }

    public function store(StudentRequest $request)
    {
        $validated = $request->validated();

        try {
            $activeSchoolYear = SchoolYear::where('active', true)->first();

            if (!$activeSchoolYear) {
                return $this->errorResponse(
                    "No se puede inscribir al alumno porque no hay ningún ciclo escolar marcado como activo en el sistema.",
                    422
                );
            }

            $studentData = DB::transaction(function () use ($validated, $activeSchoolYear, $request) {
                $group = Group::findOrFail($validated['group_id']);

                // Generar la nomenclatura exacta para el Padre de Familia (Ej: Juan_H_G_1E)
                $username = $this->generateParentUsername(
                    $validated['name'],
                    $validated['lastname'],
                    $group->groupGrade->name,
                    $group->section
                );

                $parentUser = User::create([
                    'name'     => 'Padre de ' . $validated['name'],
                    'lastname' => $validated['lastname'] ?? 'Sin apellido',
                    'username' => $username,
                    'email'    => null,
                    'password' => Hash::make($username),
                    'role_id'  => 4,
                    'school_id' => auth()->user()->school_id,
                ]);

                $photoPath = null;
                if ($request->hasFile('photo')) {
                    $photoPath = $request->file('photo')->store('students/photos', 'public');
                }

                $student = Student::create([
                    'user_id'       => null,
                    'name'          => $validated['name'],
                    'lastname'      => $validated['lastname'],
                    'birthday'      => $validated['birthday'],
                    'gender'        => $validated['gender'],
                    'photo_path'    => $photoPath,
                    'grade_average' => 0.0,
                ]);

                $student->groups()->attach($validated['group_id'], [
                    'school_year_id' => $activeSchoolYear->id,
                    'active'         => '1'
                ]);

                $student->parents()->attach($parentUser->id);

                return [
                    'student'         => $student->load('groups'),
                    'parent_username' => $username
                ];
            });

            return $this->successResponse(
                [
                    'id'              => $studentData['student']->id,
                    'parent_username' => $studentData['parent_username']
                ],
                "Inscripción completada de manera exitosa.",
                201
            );

        } catch (Exception $e) {
            return $this->errorResponse(
                "Hubo un fallo al procesar la inscripción escolar.",
                500,
                $e->getMessage()
            );
        }
    }

    private function generateParentUsername(string $name, string $lastname, string $grade, string $section): string
    {
        $firstName = Str::slug(explode(' ', trim($name))[0], '');

        $lastNameParts = explode(' ', trim($lastname));
        $initialPaterno = isset($lastNameParts[0]) ? Str::upper(substr($lastNameParts[0], 0, 1)) : 'X';
        $initialMaterno = isset($lastNameParts[1]) ? Str::upper(substr($lastNameParts[1], 0, 1)) : 'X';

        $cleanGrade = filter_var($grade, FILTER_SANITIZE_NUMBER_INT);
        if (empty($cleanGrade)) {
            $cleanGrade = Str::substr($grade, 0, 1);
        }
        $groupCode  = $cleanGrade . Str::upper($section);

        $baseUsername = ucfirst($firstName) . "_{$initialPaterno}_{$initialMaterno}_{$groupCode}";

        $finalUsername = $baseUsername;
        $counter = 1;
        while (User::where('username', $finalUsername)->exists()) {
            $finalUsername = $baseUsername . "_" . $counter;
            $counter++;
        }

        return $finalUsername;
    }

    public function show(Student $student)
    {
        return $this->successResponse(new StudentResource($student->load(['groups.groupGrade.educationalLevel', 'user', 'parents', 'diplomas'])));
    }

    public function update(Request $request, Student $student)
    {
        if ($request->input('tutor.email') === 'Sin correo registrado') {
            $tutorData = $request->input('tutor');
            $tutorData['email'] = null;
            $request->merge(['tutor' => $tutorData]);
        }

        $validated = $request->validate([
            'name'              => 'required|string|max:255',
            'lastname'          => 'required|string|max:255',
            'birthday'          => 'required|date',
            'gender'            => 'required|in:male,female,other',
            'group_id'          => 'required|exists:groups,id',
            'photo'             => 'nullable|image|max:2048',
            'tutor.name'        => 'nullable|string|max:255',
            'tutor.lastname'    => 'nullable|string|max:255',
            'tutor.email'       => 'nullable|email|max:255',
            'tutor.username'    => 'nullable|string|max:255',
            'diplomas'          => 'nullable|array',
            'diplomas.*.title'  => 'required_with:diplomas|string|max:255',
            'diplomas.*.id'     => 'nullable',
            'diplomas.*.file'   => 'nullable|file|mimes:pdf,jpeg,png,jpg|max:4096',
        ]);

        try {
            DB::transaction(function () use ($validated, $request, $student) {

                if ($request->hasFile('photo')) {
                    if ($student->photo_path) {
                        Storage::disk('public')->delete($student->photo_path);
                    }
                    $student->photo_path = $request->file('photo')->store('students/photos', 'public');
                }

                $student->name     = $validated['name'];
                $student->lastname = $validated['lastname'];
                $student->birthday = $validated['birthday'];
                $student->gender   = $validated['gender'];
                $student->save();

                if (!empty($validated['group_id'])) {
                    $activeSchoolYear = SchoolYear::where('active', true)->first();
                    $schoolYearId = $activeSchoolYear?->id ?? $student->groups()->first()?->pivot->school_year_id;

                    $student->groups()->sync([
                        $validated['group_id'] => [
                            'school_year_id' => $schoolYearId,
                            'active'         => '1'
                        ]
                    ]);
                }

                $tutorUser = $student->parents()->first();
                if ($tutorUser && $request->has('tutor')) {
                    $tutorUser->update([
                        'name'     => $validated['tutor']['name'] ?? $tutorUser->name,
                        'lastname' => $validated['tutor']['lastname'] ?? $tutorUser->lastname,
                        'email'    => $validated['tutor']['email'] ?? $tutorUser->email,
                        'username' => $validated['tutor']['username'] ?? $tutorUser->username,
                    ]);
                }

                if ($request->has('diplomas')) {
                    $incomingIds = [];

                    $activeSchoolYear = SchoolYear::where('active', true)->first();
                    $activePeriod = AcademicPeriod::where('active', true)->first();
                    $activeGradingPeriod = GradingPeriod::where('status', 'inProgress')->first();

                    foreach ($request->input('diplomas') as $index => $diplomaData) {
                        $diplomaId = $diplomaData['id'] ?? null;

                        $filePath = null;
                        if ($request->hasFile("diplomas.{$index}.file")) {
                            $filePath = $request->file("diplomas.{$index}.file")->store('students/diplomas', 'public');
                        }

                        if ($diplomaId && !str_starts_with($diplomaId, 'temp_')) {
                            // Actualizar existente
                            $diploma = StudentDiploma::findOrFail($diplomaId);
                            $diploma->title = $diplomaData['title'];

                            if ($filePath) {
                                if ($diploma->diploma_path) {
                                    Storage::disk('public')->delete($diploma->diploma_path);
                                }
                                $diploma->diploma_path = $filePath;
                            }
                            $diploma->save();
                            $incomingIds[] = $diploma->id;
                        } else {
                            // Crear nuevo
                            $newDiploma = StudentDiploma::create([
                                'student_id'         => $student->id,
                                'school_year_id'     => $activeSchoolYear?->id ?? $student->groups()->first()?->pivot->school_year_id,
                                'academic_period_id' => $activePeriod?->id,
                                'grading_period_id' => $activeGradingPeriod?->id,
                                'title'              => $diplomaData['title'],
                                'diploma_path'       => $filePath ?? '',
                            ]);
                            $incomingIds[] = $newDiploma->id;
                        }
                    }

                    // Limpiar eliminados
                    $diplomasToDelete = StudentDiploma::where('student_id', $student->id)
                        ->whereNotIn('id', $incomingIds)
                        ->get();

                    foreach ($diplomasToDelete as $delDiploma) {
                        if ($delDiploma->diploma_path) {
                            Storage::disk('public')->delete($delDiploma->diploma_path);
                        }
                        $delDiploma->delete();
                    }
                }
            });

            return $this->successResponse(
                new StudentResource($student->load(['groups.groupGrade.educationalLevel', 'user', 'parents', 'diplomas'])),
                'Expediente académico sincronizado correctamente.'
            );

        } catch (Exception $e) {
            return $this->errorResponse("Error al sincronizar los cambios", 500, $e->getMessage());
        }
    }

    public function destroy(Student $student)
    {
        $student->delete();
        return $this->successResponse(null, 'Perfil de alumno eliminado');
    }
}
