<?php

use App\Http\Controllers\Academic\GradeController;
use App\Http\Controllers\Academic\GroupController;
use App\Http\Controllers\Academic\HonorRollOverrideController;
use App\Http\Controllers\Academic\StudentDiplomaController;
use App\Http\Controllers\Admin\AcademicPeriodController;
use App\Http\Controllers\Admin\EducationalLevelController;
use App\Http\Controllers\Admin\GradingPeriodController;
use App\Http\Controllers\Admin\SchoolController;
use App\Http\Controllers\Admin\SchoolYearController;
use App\Http\Controllers\Admin\StudentController;
use App\Http\Controllers\Admin\SubjectController;
use App\Http\Controllers\Admin\TeacherController;
use App\Http\Controllers\Admin\TeacherPermissionController;
use App\Http\Controllers\Admin\UserController;
use App\Http\Controllers\Auth\AuditController;
use App\Http\Controllers\Auth\AuthController;
use App\Http\Controllers\Auth\NotificationController;
use App\Http\Controllers\Auth\RoleController;
use App\Http\Controllers\Comunication\EventController;
use App\Http\Controllers\Comunication\GalleryController;
use App\Http\Controllers\Comunication\InternalComunicationController;
use App\Http\Controllers\Comunication\OfficialComunicationController;
use App\Http\Controllers\Comunication\PostController;
use App\Http\Controllers\Comunication\PostTagCatalogController;
use App\Http\Controllers\Comunication\SchoolCalendarController;
use App\Http\Controllers\Sports\EventParticipantController;
use App\Http\Controllers\Sports\MatchEventController;
use App\Http\Controllers\Sports\MatchStatRecordController;
use App\Http\Controllers\Sports\SchoolTeamController;
use App\Http\Controllers\Sports\SportController;
use App\Http\Controllers\Sports\SportEventController;
use App\Http\Controllers\Sports\SportLeaderController;
use App\Http\Controllers\Sports\SportStageController;
use App\Http\Controllers\Sports\SportStatDefinitionController;
use App\Http\Controllers\Sports\SportTeamRankingController;
use Illuminate\Support\Facades\Route;


// Rutas públicas (sin token)
Route::post('/login', [AuthController::class, 'login']);

Route::middleware(['auth:sanctum'])->group(function () {

    Route::apiResource('galleries', GalleryController::class);
    Route::apiResource('events', EventController::class);

    // Deportes Core y Tablas
    Route::apiResource('sports', SportController::class)->only(['index']);
    Route::apiResource('sport-stages', SportStageController::class);
    Route::apiResource('school-teams', SchoolTeamController::class);
    Route::apiResource('sport-team-rankings', SportTeamRankingController::class);

    // Deportes en Vivo
    Route::apiResource('sport-events', SportEventController::class);
    Route::apiResource('event-participants', EventParticipantController::class)->only(['store']);
    Route::apiResource('sport-stat-definitions', SportStatDefinitionController::class);
    Route::apiResource('match-events', MatchEventController::class)->only(['store']);
    Route::apiResource('match-stat-records', MatchStatRecordController::class)->only(['store']);
    Route::apiResource('sport-leaders', SportLeaderController::class);

    // --- RUTAS DE ADMINISTRACIÓN DE DEPORTES ---
    // Solo los administradores pueden crear, actualizar o borrar deportes globales
    Route::middleware(['role:admin'])->group(function () {
        Route::post('sports', [SportController::class, 'store']);
        Route::put('sports/{id}', [SportController::class, 'update']);
        Route::delete('sports/{id}', [SportController::class, 'destroy']);

        Route::get('audits', [AuditController::class, 'index']);
        Route::get('audits/{audit}', [AuditController::class, 'show']);

        Route::apiResource('users', UserController::class);
        Route::apiResource('roles', RoleController::class)->only(['index', 'show']);
        Route::apiResource('teachers', TeacherController::class);
        Route::apiResource('students', StudentController::class);
        Route::apiResource('teacher-permissions', TeacherPermissionController::class);

        Route::apiResource('schools', SchoolController::class)->only(['index', 'store', 'update']);
        Route::apiResource('educational-levels', EducationalLevelController::class);
        Route::apiResource('school-years', SchoolYearController::class);
        Route::apiResource('academic-periods', AcademicPeriodController::class)->only(['index', 'store']);
        Route::apiResource('grading-periods', GradingPeriodController::class);
        Route::apiResource('subjects', SubjectController::class);
        Route::apiResource('groups', GroupController::class);
    });

    // --- RUTAS DE GESTIÓN DE EVENTOS / PARTIDOS ---
    // Tanto administradores como profesores (coaches) pueden programar y actualizar partidos
    Route::middleware(['role:admin,teacher'])->group(function () {
        Route::post('sport-events', [SportEventController::class, 'store']);
        Route::put('sport-events/{id}', [SportEventController::class, 'update']);
        Route::apiResource('post-tags-catalog', PostTagCatalogController::class);
        Route::apiResource('posts', PostController::class);
        Route::apiResource('official-comunications', OfficialComunicationController::class);
        Route::apiResource('internal-comunications', InternalComunicationController::class);
        Route::apiResource('school-calendar', SchoolCalendarController::class);

        Route::apiResource('grades', GradeController::class);
        Route::apiResource('honor-roll-overrides', HonorRollOverrideController::class);
        Route::apiResource('student-diplomas', StudentDiplomaController::class);
    });

    // --- RUTAS PÚBLICAS/LECTURA ---
    Route::middleware(['role:admin,teacher,student,parent'])->group(function () {
        Route::get('sports', [SportController::class, 'index']);
        Route::get('sports/{id}', [SportController::class, 'show']);
        Route::get('sport-events', [SportEventController::class, 'index']);
        Route::get('notifications', [NotificationController::class, 'index']);
        Route::patch('notifications/{notification}/read', [NotificationController::class, 'markAsRead']);
    });

});
