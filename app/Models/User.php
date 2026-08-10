<?php

namespace App\Models;

// use Illuminate\Contracts\Auth\MustVerifyEmail;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Laravel\Sanctum\HasApiTokens;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasOne;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;

class User extends Authenticatable
{
    use HasFactory, Notifiable, HasApiTokens;

    protected $fillable = [
        'role_id',
        'school_id',
        'name',
        'lastname',
        'title',
        'username',
        'email',
        'password',
        'signature_path',
        'signature_enabled',
        'active',
        'last_login_at',
        'fcm_token',
        'device_type',
        'device_name',
        'last_used_at',
    ];

    protected $hidden = [
        'password',
        'remember_token'
    ];

    protected $casts = [
        'email_verified_at' => 'datetime',
        'password' => 'hashed',
        'active' => 'boolean',
        'signature_enabled' => 'boolean',
        'last_login_at' => 'datetime',
    ];

    public function role(): BelongsTo
    {
        return $this->belongsTo(Role::class);
    }

    public function school(): BelongsTo
    {
        return $this->belongsTo(School::class);
    }

    public function teacher(): HasOne
    {
        return $this->hasOne(Teacher::class);
    }
    public function student(): HasOne
    {
        return $this->hasOne(Student::class);
    }

    public function teacherPermissions(): HasMany
    {
        return $this->hasMany(TeacherPermission::class);
    }

    public function children(): BelongsToMany
    {
        return $this->belongsToMany(Student::class, 'parent_student', 'parent_user_id', 'student_id')
            ->withTimestamps();
    }

    public function internalCommunications(): BelongsToMany
    {
        return $this->belongsToMany(InternalCommunication::class, 'internal_communication_user', 'internal_communication_id', 'user_id')
            ->withPivot('notes')
            ->withTimestamps();
    }

    public function notifications(): HasMany
    {
        return $this->hasMany(Notification::class);
    }

    public function galleryLikes(): HasMany
    {
        return $this->hasMany(GalleryLike::class);
    }

    public function students()
    {
        return $this->belongsToMany(Student::class, 'parent_student', 'parent_user_id', 'student_id');
    }

    public function permissions(): HasMany
    {
        return $this->hasMany(TeacherPermission::class, 'user_id');
    }

    public function fcmTokens(): HasMany
    {
        return $this->hasMany(UserFcmToken::class);
    }
}
