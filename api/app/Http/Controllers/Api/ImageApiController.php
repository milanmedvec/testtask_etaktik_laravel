<?php

namespace App\Http\Controllers\Api;

use App\Classes\ApiController\HasDestroy;
use App\Classes\ApiController\HasIndex;
use App\Classes\ApiController\HasShow;
use App\Models\Image;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Cache;
use Illuminate\Support\Facades\Validator;

class ImageApiController extends ApiController
{
    use HasIndex;
    use HasShow;
    use HasDestroy;

    public function __construct()
    {
        parent::__construct(new Image());
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            // Author ID is required and must be an integer (foreign key)
            'author_id' => 'required|integer|exists:authors,id',
            // Title is required and must be a string
            'title' => 'required|string',
            // URL is required and must be a string
            'url' => 'required|url',
            // Tags IDs is an array of integers
            'tags_ids' => 'array',
            // Tags IDs must be integers
            'tags_ids.*' => 'integer:exists:tags,id',
        ]);

        $image = Image::create($validated);

        $tags = $request->input('tags_ids');
        if (is_array($tags)) {
            $image->tags()->sync($tags);
        }

        return $image;
    }

    public function update(Request $request, $id)
    {
        $validator = Validator::make(['id' => $id], [
            'id' => 'int',
        ]);

        if ($validator->fails()) {
            return response()->json(['error' => 'Invalid ID'], 400);
        }

        $cacheKey = $this->getEntityCacheKey($id);
        Cache::forget($cacheKey);

        $validated = $request->validate([
            // Author ID must be an integer (foreign key)
            'author_id' => 'integer|exists:authors,id',
            // Title must be a string
            'title' => 'string',
            // URL must be a string
            'url' => 'url',
            // Tags IDs is an array of integers
            'tags_ids' => 'array',
            // Tags IDs must be integers
            'tags_ids.*' => 'integer:exists:tags,id',
        ]);

        $image = Image::findOrFail($id);
        $image->update($validated);

        $tags = $request->input('tags_ids');
        if (is_array($tags)) {
            $image->tags()->sync($tags);
        }

        return $image;
    }

}
