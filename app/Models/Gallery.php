<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;

class Gallery extends Model
{
    protected $fillable = [
        'school_id',
        'title',
        'description',
        'value_tag_id',
        'emotion_tag_id',
        'category_tag'
    ];

    public function school(): BelongsTo
    {
        return $this->belongsTo(School::class);
    }

    public function valueTag(): BelongsTo
    {
        return $this->belongsTo(PostTagCatalog::class, 'value_tag_id');
    }

    public function emotionTag(): BelongsTo
    {
        return $this->belongsTo(PostTagCatalog::class, 'emotion_tag_id');
    }

    public function items(): HasMany
    {
        return $this->hasMany(GalleryItem::class);
    }

    public function posts(): HasMany
    {
        return $this->hasMany(Post::class);
    }

    public function likes(): HasMany
    {
        return $this->hasMany(GalleryLike::class);
    }
}
