<?php

namespace App\Http\Controllers\Api;

use App\Classes\ApiController\HasDestroy;
use App\Classes\ApiController\HasIndex;
use App\Classes\ApiController\HasShow;
use App\Models\Author;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Cache;
use Illuminate\Support\Facades\Validator;

class AuthorApiController extends ApiController
{
    use HasIndex;
    use HasShow;
    use HasDestroy;

    public function __construct()
    {
        parent::__construct(new Author());
    }

    public function store(Request $request): JsonResponse
    {
        $validated = $request->validate([
            // First Name is required and must be a string
            'first_name' => 'required|string',
            // Last Name is required and must be a string
            'last_name' => 'required|string',
        ]);

        $author = Author::create($validated);

        return response()->json($author, 201);
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
            // First Name must be a string
            'first_name' => 'string',
            // Last Name must be a string
            'last_name' => 'string',
        ]);

        $model = Author::findOrFail($id);
        $model->update($validated);

        return response()->json($model);
    }
}
