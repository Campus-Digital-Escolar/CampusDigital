<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Http\Requests\Admin\TeacherRequest;
use App\Http\Resources\Admin\TeacherResource;
use App\Models\GroupTeacher;
use App\Models\SchoolYear;
use App\Models\Teacher;
use App\Traits\ApiResponse;
use Exception;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Storage;

class TeacherController extends Controller
{
    use ApiResponse;

    private array $relations = [
        'user.role',
        'user.school',
        'user.permissions',
        'jobPosition',
        'tutoredGroups.groupGrade.educationalLevel',
        'groupsTeachers.group.groupGrade.educationalLevel',
        'groupsTeachers.subject',
    ];

    public function index()
    {
        try {
            $teachers = Teacher::with($this->relations)
                ->orderBy('lastname', 'asc')
                ->get();

            return $this->successResponse(TeacherResource::collection($teachers), "Listado de docentes obtenido con éxito.");
        } catch (Exception $e) {
            return $this->errorResponse("Error al obtener docentes", 500, $e->getMessage());
        }
    }

    public function store(TeacherRequest $request)
    {
        $validated = $request->validated();

        try {
            $activeSchoolYear = SchoolYear::where('active', true)->first();

            if (!empty($validated['groups']) && !$activeSchoolYear) {
                return $this->errorResponse("No hay ningún ciclo escolar marcado como activo.", 422);
            }

            $teacher = DB::transaction(function () use ($validated, $request, $activeSchoolYear) {
                $photoPath = null;
                if ($request->hasFile('photo')) {
                    $photoPath = $request->file('photo')->store('teachers/photos', 'public');
                }

                $teacher = Teacher::create([
                    'user_id'    => $validated['user_id'] ?? null,
                    'name'       => $validated['name'],
                    'lastname'   => $validated['lastname'],
                    'title'      => $validated['title'],
                    'profession' => $validated['profession'],
                    'job_position_id' => $validated['job_position_id'],
                    'photo_path' => $photoPath,
                ]);

                if (!empty($validated['groups']) && $activeSchoolYear) {
                    foreach ($validated['groups'] as $groupAssign) {
                        GroupTeacher::create([
                            'teacher_id'     => $teacher->id,
                            'group_id'       => $groupAssign['group_id'],
                            'subject_id'     => $groupAssign['subject_id'],
                            'school_year_id' => $activeSchoolYear->id,
                        ]);
                    }
                }

                return $teacher;
            });

            return $this->successResponse(
                new TeacherResource($teacher->load(['user', 'groupsTeachers.group', 'groupsTeachers.subject'])),
                'Perfil de profesor creado con éxito',
                201
            );

        } catch (Exception $e) {
            return $this->errorResponse("Fallo al registrar docente", 500, $e->getMessage());
        }
    }

    public function show(Teacher $teacher)
    {
        return $this->successResponse(
            new TeacherResource($teacher->load($this->relations))
        );
    }

    public function update(TeacherRequest $request, Teacher $teacher)
    {
        $validated = $request->validated();

        try {
            $activeSchoolYear = SchoolYear::where('active', true)->first();

            if (isset($validated['groups']) && !$activeSchoolYear) {
                return $this->errorResponse("No hay un ciclo escolar activo para asignar grupos.", 422);
            }

            DB::transaction(function () use ($validated, $request, $teacher, $activeSchoolYear) {
                if ($request->hasFile('photo')) {
                    if ($teacher->photo_path) {
                        Storage::disk('public')->delete($teacher->photo_path);
                    }
                    $teacher->photo_path = $request->file('photo')->store('teachers/photos', 'public');
                }

                $teacher->title      = $validated['title'];
                $teacher->profession = $validated['profession'];
                $teacher->job_position_id = $validated['job_position_id'];
                if (isset($validated['name'])) $teacher->name = $validated['name'];
                if (isset($validated['lastname'])) $teacher->lastname = $validated['lastname'];
                $teacher->save();

                // Re-sincronizar asignaciones
                if (isset($validated['groups']) && $activeSchoolYear) {
                        GroupTeacher::where('teacher_id', $teacher->id)
                            ->where('school_year_id', $activeSchoolYear->id)
                            ->delete();

                        foreach ($validated['groups'] as $groupAssign) {
                            GroupTeacher::create([
                                'teacher_id'     => $teacher->id,
                                'group_id'       => $groupAssign['group_id'],
                                'subject_id'     => $groupAssign['subject_id'],
                                'school_year_id' => $activeSchoolYear->id,
                            ]);
                        }
                    }
            });

            return $this->successResponse(
                new TeacherResource($teacher->load($this->relations)),
                'Perfil de profesor actualizado con éxito'
            );

        } catch (Exception $e) {
            return $this->errorResponse("Fallo al actualizar docente", 500, $e->getMessage());
        }
    }

    public function destroy(Teacher $teacher)
    {
        if ($teacher->photo_path) {
            Storage::disk('public')->delete($teacher->photo_path);
        }
        $teacher->delete();
        return $this->successResponse(null, 'Perfil de profesor eliminado');
    }
}
