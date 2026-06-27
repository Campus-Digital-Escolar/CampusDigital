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
        'active',
    ];

    protected $hidden = [
        'password',
        'remember_token'
    ];

    protected $casts = [
        'email_verified_at' => 'datetime',
        'password' => 'hashed',
        'active' => 'boolean',
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

    public function internalComunications(): BelongsToMany
    {
        return $this->belongsToMany(InternalComunication::class, 'internal_comunication_user');
    }

    public function notifications(): HasMany
    {
        return $this->hasMany(Notification::class);
    }

    public function galleryLikes(): HasMany
    {
        return $this->hasMany(GalleryLike::class);
    }
}
