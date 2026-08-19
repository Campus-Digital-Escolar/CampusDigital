<?php

use App\Http\Controllers\Academic\GradeController;
use App\Http\Controllers\Academic\GroupController;
use App\Http\Controllers\Academic\HonorRollController;
use App\Http\Controllers\Academic\HonorRollOverrideController;
use App\Http\Controllers\Academic\StudentDiplomaController;
use App\Http\Controllers\Admin\AcademicPeriodController;
use App\Http\Controllers\Admin\EducationalLevelController;
use App\Http\Controllers\Admin\FamilyUserController;
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
use App\Http\Controllers\Auth\JobPositionController;
use App\Http\Controllers\Auth\NotificationController;
use App\Http\Controllers\Auth\RoleController;
use App\Http\Controllers\Communication\OfficialCommunicationController;
use App\Http\Controllers\Communication\EventController;
use App\Http\Controllers\Communication\GalleryController;
use App\Http\Controllers\Communication\InternalCommunicationController;
use App\Http\Controllers\Communication\PostController;
use App\Http\Controllers\Communication\PostTagCatalogController;
use App\Http\Controllers\Communication\SchoolCalendarController;
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


// ─── RUTAS PÚBLICAS (SIN TOKEN) ───────────────────────────────────────────
Route::post('/login', [AuthController::class, 'login']);
Route::post('/sync-password-reset', [AuthController::class, 'syncPasswordReset']);

// ─── RUTAS CON AUTENTICACIÓN (CUALQUIER ROL) ────────────────────────────────
Route::middleware(['auth:sanctum'])->group(function () {
    // Auth & Perfil
    Route::post('/logout', [AuthController::class, 'logout']);
    Route::get('/me', [AuthController::class, 'me']);

    Route::post('/save-fcm-token', [UserController::class, 'updateFcmToken']);

    // Notificaciones
    Route::prefix('notifications')->group(function () {
        Route::get('/', [NotificationController::class, 'index']);
        Route::get('/unread', [NotificationController::class, 'unread']);
        Route::get('/{notification}', [NotificationController::class, 'show']);
        Route::patch('/{notification}/read', [NotificationController::class, 'markAsRead']);
        Route::patch('/read-all', [NotificationController::class, 'markAllAsRead']);
        Route::delete('/{notification}', [NotificationController::class, 'destroy']);
    });
    // Funcionalidad de Likes en Galerías (Cualquier usuario puede dar/quitar like)
    Route::post('galleries/{gallery}/like', [GalleryController::class, 'toggleLike']);
    Route::apiResource('post-tags-catalog', PostTagCatalogController::class)->only(['index', 'show']);

    Route::get('official-communications/signers', [OfficialCommunicationController::class, 'getSigners']);
    Route::get('official-communications/search-adjectives', [OfficialCommunicationController::class, 'searchAdjectives']);

    // ─── RUTAS SÓLO LECTURA (Cualquier usuario logueado puede consultar) ───
    Route::apiResource('galleries', GalleryController::class)->only(['index', 'show']);
    Route::apiResource('events', EventController::class)->only(['index', 'show']);
    Route::apiResource('publications', PostController::class)->only(['index', 'show']);
    Route::apiResource('official-communications', OfficialCommunicationController::class)->only(['index', 'show']);
    Route::apiResource('school-calendar', SchoolCalendarController::class)->only(['index', 'show']);

    // Deportes
    Route::apiResource('sports', SportController::class)->only(['index', 'show']);

    Route::prefix('sports/{sport}')->group(function () {
        // Equipos inscritos al deporte
        Route::get('/teams', [SportController::class, 'teams']);


        // Tabla general / standings
        Route::get('/standings', [SportController::class, 'standings']);

        // Definiciones estadísticas
        Route::get('/stat-definitions', [SportController::class, 'statDefinitions']);
    });

    Route::apiResource('sport-events', SportEventController::class)->only(['index', 'show']);
    Route::apiResource('sport-stages', SportStageController::class)->only(['index', 'show']);
    Route::apiResource('school-teams', SchoolTeamController::class)->only(['index', 'show']);
    Route::apiResource('sport-team-rankings', SportTeamRankingController::class)->only(['index', 'show']);
    Route::apiResource('sport-leaders', SportLeaderController::class)->only(['index', 'show']);
    Route::apiResource('event-participants', EventParticipantController::class)->only(['index', 'show']);

    Route::apiResource('sport-stat-definitions', SportStatDefinitionController::class)->only(['index', 'show']);
    Route::apiResource('match-events', MatchEventController::class)->only(['index', 'show']);
    Route::apiResource('match-stat-records', MatchStatRecordController::class)->only(['index', 'show']);
    Route::apiResource('sport-leaders', SportLeaderController::class)->only(['index', 'show']);
    Route::apiResource('schools', SchoolController::class)->only(['index', 'show']);
    // Academico
    Route::apiResource('groups',GroupController::class)->only(['index', 'show']);

    // ─── ADMINISTRADOR Y DOCENTE ─────────────────────────
    Route::middleware(['role:Administrador,Docente'])->group(function () {
        // Deportes
        Route::apiResource('sports', SportController::class)->except(['index', 'show']);

        Route::prefix('sports/{sport}')->group(function () {
            // Equipos inscritos al deporte
            Route::post('/teams', [SportController::class, 'storeTeam']);

            // Próximos partidos / encuentros
            Route::post('/event', [SportController::class, 'storeEvent']);

            // Definiciones estadísticas
            Route::post('/stat-definitions', [SportController::class, 'storeStatDefinition']);

            // Eventos en vivo
            Route::post('/match-stat-records', [SportController::class, 'storeMatchStatRecord']);
        });

        Route::apiResource('sport-events', SportEventController::class)->except(['index', 'show']);
        Route::apiResource('sport-stages', SportStageController::class)->except(['index', 'show']);
        Route::apiResource('school-teams', SchoolTeamController::class)->except(['index', 'show']);
        Route::apiResource('sport-team-rankings', SportTeamRankingController::class)->except(['index', 'show']);
        Route::apiResource('sport-leaders', SportLeaderController::class)->except(['index', 'show']);
        Route::apiResource('event-participants', EventParticipantController::class)->except(['index', 'show']);

        Route::apiResource('sport-stat-definitions', SportStatDefinitionController::class)->except(['index', 'show']);
        Route::apiResource('match-events', MatchEventController::class)->except(['index', 'show']);
        Route::apiResource('match-stat-records', MatchStatRecordController::class)->except(['index', 'show']);
        Route::apiResource('sport-leaders', SportLeaderController::class)->except(['index', 'show']);

        // Academico
        Route::apiResource('post-tags-catalog', PostTagCatalogController::class)->except(['index', 'show']);
        Route::apiResource('official-communications', OfficialCommunicationController::class)->except(['index', 'show']);
        Route::post('internal-communications/{id}/notes', [InternalCommunicationController::class, 'updateNotes']);
        Route::apiResource('internal-communications', InternalCommunicationController::class);
        Route::apiResource('school-calendar', SchoolCalendarController::class)->except(['index', 'show']);
        Route::apiResource('galleries', GalleryController::class)->except(['index', 'show']);
        Route::apiResource('events', EventController::class)->except(['index', 'show']);
        Route::apiResource('publications', PostController::class)->except(['index', 'show']);

        Route::post('grades/bulk-store', [GradeController::class, 'bulkStore']);
        Route::put('grades/bulk-update', [GradeController::class, 'bulkUpdate']);
        Route::apiResource('grades', GradeController::class)->except('destroy');
        Route::get('grades/summary', [GradeController::class, 'summary']);
        Route::apiResource('honor-roll', HonorRollController::class)->only(['index']);
        Route::apiResource('honor-roll-overrides', HonorRollOverrideController::class)->except('destroy');
        Route::apiResource('student-diplomas', StudentDiplomaController::class);

        Route::apiResource('groups', GroupController::class)->except(['index', 'show']);
        Route::apiResource('students', StudentController::class);
        Route::get('users/staff', [UserController::class, 'getStaffUsers']);
        Route::apiResource('users', UserController::class)->only('index');
        Route::get('family-users', [FamilyUserController::class, 'index']);

        Route::apiResource('educational-levels', EducationalLevelController::class)->only('index');
        Route::apiResource('school-years', SchoolYearController::class)->only('index');
        Route::apiResource('academic-periods', AcademicPeriodController::class)->only('index');
        Route::apiResource('grading-periods', GradingPeriodController::class)->only('index');
        Route::apiResource('subjects', SubjectController::class)->only('index');
        Route::apiResource('roles', RoleController::class)->only('index');
        Route::apiResource('job-positions', JobPositionController::class)->only(['index', 'show']);
    });


    // ─── SÓLO ADMINISTRADOR ─────────────────────────
    Route::middleware(['role:Administrador'])->group(function () {
        Route::post('/register', [AuthController::class, 'register']);

        // Deportes
        Route::apiResource('sports', SportController::class)->except(['index', 'show']);

        // Auditorías
        Route::get('audits', [AuditController::class, 'index']);
        Route::get('audits/{audit}', [AuditController::class, 'show']);

        // Administración academica
        Route::apiResource('teachers', TeacherController::class);
        Route::apiResource('teacher-permissions', TeacherPermissionController::class)->except(['destroy']);
        Route::apiResource('schools', SchoolController::class)->except(['index', 'show', 'destroy']);
        Route::apiResource('educational-levels', EducationalLevelController::class)->except(['index']);
        Route::apiResource('school-years', SchoolYearController::class)->except(['index']);
        Route::apiResource('academic-periods', AcademicPeriodController::class)->except(['index']);
        Route::apiResource('grading-periods', GradingPeriodController::class)->except(['index']);
        Route::apiResource('subjects', SubjectController::class)->except(['index']);
        Route::apiResource('roles', RoleController::class)->except(['index',]);
        Route::apiResource('users', UserController::class)->except(['index',]);
        Route::apiResource('job-positions', JobPositionController::class)->except(['index', 'show']);
    });
});
