<?php

namespace App\Http\Controllers\Api;

use App\Classes\ApiController\HasDestroy;
use App\Classes\ApiController\HasIndex;
use App\Classes\ApiController\HasShow;
use App\Models\Comment;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Cache;
use Illuminate\Support\Facades\Validator;

class CommentApiController extends ApiController
{
    use HasIndex;
    use HasShow;
    use HasDestroy;

    public function __construct()
    {
        parent::__construct(new Comment());
    }

    protected function validateUpdateRequest(Request $request): void
    {
        $request->validate([
            // Body must be a string and is required
            'body' => 'required|string',
        ]);
    }

    public function update(Request $request, mixed $id): JsonResponse
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
            // Body must be a string
            'body' => 'string',
        ]);

        $model = Comment::findOrFail($id);
        $model->update($validated);

        return response()->json($model);
    }
}
