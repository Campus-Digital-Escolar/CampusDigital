<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;

class Post extends Model
{
    protected $fillable = [
        'school_id',
        'user_id',
        'gallery_id',
        'title',
        'body',
        'value_tag_id',
        'emotion_tag_id'
    ];

    public function school(): BelongsTo
    {
        return $this->belongsTo(School::class);
    }

    public function user(): BelongsTo
    {
        return $this->belongsTo(User::class);
    }

    public function gallery(): BelongsTo
    {
        return $this->belongsTo(Gallery::class);
    }

    public function valueTag(): BelongsTo
    {
        return $this->belongsTo(PostTagCatalog::class, 'value_tag_id');
    }

    public function emotionTag(): BelongsTo
    {
        return $this->belongsTo(PostTagCatalog::class, 'emotion_tag_id');
    }

    public function students(): BelongsToMany
    {
        return $this->belongsToMany(Student::class, 'post_student', 'post_id', 'student_id');
    }
}
