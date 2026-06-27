<?php

namespace App\Http\Controllers\Comunication;

use App\Http\Controllers\Controller;
use App\Http\Requests\Comunication\PostTagCatalogRequest;
use App\Http\Resources\Comunication\PostTagCatalogResource;
use App\Models\PostTagCatalog;
use App\Traits\ApiResponse;

class PostTagCatalogController extends Controller
{
    use ApiResponse;

    public function index()
    {
        return $this->successResponse(PostTagCatalogResource::collection(PostTagCatalog::all()));
    }

    public function store(PostTagCatalogRequest $request)
    {
        $tag = PostTagCatalog::create($request->validated());
        return $this->successResponse(new PostTagCatalogResource($tag), 'Etiqueta creada', 21);
    }

    public function show(PostTagCatalog $postTagsCatalog)
    {
        return $this->successResponse(new PostTagCatalogResource($postTagsCatalog));
    }

    public function update(PostTagCatalogRequest $request, PostTagCatalog $postTagsCatalog)
    {
        $postTagsCatalog->update($request->validated());
        return $this->successResponse(new PostTagCatalogResource($postTagsCatalog), 'Etiqueta actualizada');
    }

    public function destroy(PostTagCatalog $postTagsCatalog)
    {
        $postTagsCatalog->delete();
        return $this->successResponse(null, 'Etiqueta eliminada');
    }
}
