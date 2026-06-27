<?php

namespace App\Http\Controllers\Comunication;

use App\Http\Controllers\Controller;
use App\Http\Requests\Comunication\GalleryRequest;
use App\Http\Resources\Comunication\GalleryResource;
use App\Models\Gallery;
use App\Models\GalleryItem;
use App\Traits\ApiResponse;
use Exception;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class GalleryController extends Controller
{
    use ApiResponse;

    public function index()
    {
        return $this->successResponse(GalleryResource::collection(Gallery::with('items')->get()));
    }

    public function store(GalleryRequest $request)
    {
        $gallery = Gallery::create($request->validated());
        return $this->successResponse(new GalleryResource($gallery), 'Galería multimedia creada', 201);
    }

    public function show(Gallery $gallery)
    {
        return $this->successResponse(new GalleryResource($gallery->load('items')));
    }
}
