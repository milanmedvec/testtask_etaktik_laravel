<?php

namespace App\Http\Controllers\Api;

use App\Classes\ApiController\HasDestroy;
use App\Classes\ApiController\HasIndex;
use App\Classes\ApiController\HasShow;
use App\Models\Tag;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Cache;
use Illuminate\Support\Facades\Validator;

class TagApiController extends ApiController
{
    use HasIndex;
    use HasShow;
    use HasDestroy;

    public function __construct()
    {
        parent::__construct(new Tag());
    }

    public function store(Request $request): JsonResponse
    {
        $validated = $request->validate([
            // Name is required and must be a string
            'name' => 'required|string',
        ]);

        $tag = Tag::create($validated);

        return response()->json($tag, 201);
    }

    public function update(Request $request, mixed $id): JsonResponse
    {
        $validator = Validator::make(['id' => $id], [
            'id' => 'int',
        ]);

        if ($validator->fails()) {
            return response()->json(['error' => 'Invalid ID'], 400);
        }

        $validated = $request->validate([
            // Name must be a string
            'name' => 'string',
        ]);

        $cacheKey = $this->getEntityCacheKey($id);
        Cache::forget($cacheKey);

        $tag = Tag::findOrFail($id);
        $tag->update($validated);

        return response()->json($tag);
    }
}
