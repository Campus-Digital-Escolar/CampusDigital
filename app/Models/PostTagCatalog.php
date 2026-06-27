<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;

class PostTagCatalog extends Model
{
    protected $table = 'post_tags_catalog';
    protected $fillable = [
        'name',
        'type'
    ];

    public function galleriesWithValueTag(): HasMany
    {
        return $this->hasMany(Gallery::class, 'value_tag_id');
    }

    public function galleriesWithEmotionTag(): HasMany
    {
        return $this->hasMany(Gallery::class, 'emotion_tag_id');
    }

    public function postsWithValueTag(): HasMany
    {
        return $this->hasMany(Post::class, 'value_tag_id');
    }

    public function postsWithEmotionTag(): HasMany
    {
        return $this->hasMany(Post::class, 'emotion_tag_id');
    }
}
