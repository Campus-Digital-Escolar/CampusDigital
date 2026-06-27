<?php

namespace App\Http\Controllers\Comunication;

use App\Http\Controllers\Controller;
use App\Http\Requests\Comunication\PostRequest;
use App\Http\Resources\Comunication\PostResource;
use App\Models\Post;
use App\Traits\ApiResponse;
use Illuminate\Http\Request;

class PostController extends Controller
{
    use ApiResponse;

    public function index()
    {
        $posts = Post::with(['user', 'valueTag', 'emotionTag', 'gallery'])->latest()->get();
        return $this->successResponse(PostResource::collection($posts));
    }

    public function store(PostRequest $request)
    {
        $validated = $request->validated();
        $post = Post::create($validated);

        if (!empty($validated['student_ids'])) {
            $post->students()->sync($validated['student_ids']);
        }

        return $this->successResponse(new PostResource($post->load('students')), 'Publicación creada', 201);
    }

    public function show(Post $post)
    {
        return $this->successResponse(new PostResource($post->load(['user', 'gallery', 'students'])));
    }

    public function update(PostRequest $request, Post $post)
    {
        $validated = $request->validated();
        $post->update($validated);

        if (isset($validated['student_ids'])) {
            $post->students()->sync($validated['student_ids']);
        }

        return $this->successResponse(new PostResource($post->load('students')), 'Publicación actualizada');
    }

    public function destroy(Post $post)
    {
        $post->delete();
        return $this->successResponse(null, 'Publicación eliminada');
    }
}
