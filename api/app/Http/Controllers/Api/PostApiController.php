<?php

namespace App\Http\Controllers\Api;

use App\Classes\ApiController\HasDestroy;
use App\Classes\ApiController\HasIndex;
use App\Classes\ApiController\HasShow;
use App\Models\Post;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Cache;
use Illuminate\Support\Facades\Validator;

class PostApiController extends ApiController
{
    use HasIndex;
    use HasShow;
    use HasDestroy;

    public function __construct()
    {
        parent::__construct(new Post());
    }

    public function store(Request $request): JsonResponse
    {
        $validated = $request->validate([
            // Author ID is required and must be an integer (foreign key)
            'author_id' => 'required|integer|exists:authors,id',
            // Title is required and must be a string
            'title' => 'required|string',
            // Body is required and must be a string
            'body' => 'required|string',
            // Tags IDs is an array of integers
            'tags_ids' => 'array',
            // Tags IDs must be integers
            'tags_ids.*' => 'integer:exists:tags,id',
        ]);

        $post = Post::create($validated);

        $tags = $request->input('tags_ids');
        if (is_array($tags)) {
            $post->tags()->sync($tags);
        }

        return response()->json($post, 201);
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
            // Author ID must be an integer (foreign key)
            'author_id' => 'integer|exists:authors,id',
            // Title must be a string
            'title' => 'string',
            // Body must be a string
            'body' => 'string',
            // Tags IDs is an array of integers
            'tags_ids' => 'array',
            // Tags IDs must be integers
            'tags_ids.*' => 'integer:exists:tags,id',
        ]);

        $cacheKey = $this->getEntityCacheKey($id);
        Cache::forget($cacheKey);

        $post = Post::findOrFail($id);
        $post->update($validated);

        $tags = $request->input('tags_ids');
        if (is_array($tags)) {
            $post->tags()->sync($tags);
        }

        return response()->json($post);
    }
}
