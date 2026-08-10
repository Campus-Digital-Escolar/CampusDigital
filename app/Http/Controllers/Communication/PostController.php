<?php

namespace App\Http\Controllers\Communication;

use App\Http\Controllers\Controller;
use App\Http\Requests\Communication\PostRequest;
use App\Http\Resources\Communication\PostResource;
use App\Models\Gallery;
use App\Models\GalleryItem;
use App\Models\Post;
use App\Traits\ApiResponse;
use Exception;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class PostController extends Controller
{
    use ApiResponse;

    public function index()
    {
        try {
            $user = auth()->user();

            $posts = Post::with(['author', 'valueTag', 'emotionTag', 'gallery.items', 'taggedStudents'])
                ->when($user->school_id, function ($query, $schoolId) {
                    $query->where('school_id', $schoolId);
                })
                ->latest()
                ->get();

            return $this->successResponse(
                PostResource::collection($posts),
                'Publicaciones obtenidas con éxito'
            );
        } catch (Exception $e) {
            return $this->errorResponse(
                'Error al obtener las publicaciones',
                500,
                $e->getMessage()
            );
        }
    }

    public function store(PostRequest $request)
    {
        try {
            $validated = $request->validated();
            $user = auth()->user();

            $post = DB::transaction(function () use ($validated, $request, $user) {
                $gallery = Gallery::create([
                    'school_id'      => $validated['school_id'],
                    'title'          => "Galería: {$validated['title']}",
                    'description'    => "Álbum generado para la publicación: {$validated['title']}",
                    'value_tag_id'   => $validated['value_tag_id'] ?? null,
                    'emotion_tag_id' => $validated['emotion_tag_id'] ?? null,
                ]);

                if ($request->hasFile('media')) {
                    foreach ($request->file('media') as $file) {
                        $path = $file->store('galleries', 'public');

                        $mime = $file->getMimeType();
                        $type = str_contains($mime, 'video') ? 'video' : 'image';

                        GalleryItem::create([
                            'gallery_id' => $gallery->id,
                            'file_name'  => $file->getClientOriginalName(),
                            'file_path'  => $path,
                            'type'       => $type,
                        ]);
                    }
                }

                $post = Post::create([
                    'school_id'      => $validated['school_id'],
                    'user_id'        => $user->id,
                    'gallery_id'     => $gallery->id,
                    'title'          => $validated['title'],
                    'body'           => $validated['body'],
                    'value_tag_id'   => $validated['value_tag_id'] ?? null,
                    'emotion_tag_id' => $validated['emotion_tag_id'] ?? null,
                ]);

                if (!empty($validated['student_ids'])) {
                    $post->taggedStudents()->sync($validated['student_ids']);
                }

                $post->load(['author', 'valueTag', 'emotionTag', 'gallery.items', 'taggedStudents']);

                return $post;
            });

            return $this->successResponse(
                new PostResource($post),
                'Publicación creada exitosamente',
                201
            );
        } catch (Exception $e) {
            return $this->errorResponse(
                'Error al registrar la publicación',
                500,
                $e->getMessage()
            );
        }
    }

    public function update(PostRequest $request, Post $publication)
    {
        try {
            $validated = $request->validated();

            $post = DB::transaction(function () use ($validated, $request, $publication) {
                $publication->update([
                    'title'          => $validated['title'],
                    'body'           => $validated['body'],
                    'value_tag_id'   => $validated['value_tag_id'] ?? null,
                    'emotion_tag_id' => $validated['emotion_tag_id'] ?? null,
                ]);

                if (isset($validated['student_ids'])) {
                    $publication->taggedStudents()->sync($validated['student_ids']);
                }

                if ($request->hasFile('media')) {
                    foreach ($request->file('media') as $file) {
                        $path = $file->store('galleries', 'public');

                        $mime = $file->getMimeType();
                        $type = str_contains($mime, 'video') ? 'video' : 'image';

                        GalleryItem::create([
                            'gallery_id' => $publication->gallery_id,
                            'file_name'  => $file->getClientOriginalName(),
                            'file_path'  => $path,
                            'type'       => $type,
                        ]);
                    }
                }

                $publication->load(['author', 'valueTag', 'emotionTag', 'gallery.items', 'taggedStudents']);

                return $publication;
            });

            return $this->successResponse(
                new PostResource($post),
                'Publicación actualizada exitosamente'
            );
        } catch (Exception $e) {
            return $this->errorResponse(
                'Error al actualizar la publicación',
                500,
                $e->getMessage()
            );
        }
    }

    public function show(Post $post)
    {
        return $this->successResponse(new PostResource($post->load(['author', 'valueTag', 'emotionTag', 'gallery.items', 'taggedStudents'])));
    }

    public function destroy(Post $publication)
    {
        try {
            $publication->delete();

            return $this->successResponse(
                null,
                'Publicación eliminada correctamente'
            );
        } catch (Exception $e) {
            return $this->errorResponse(
                'Error al eliminar la publicación',
                500,
                $e->getMessage()
            );
        }
    }
}
