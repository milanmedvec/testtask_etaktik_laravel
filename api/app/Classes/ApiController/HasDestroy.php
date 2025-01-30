<?php

namespace App\Classes\ApiController;

use Illuminate\Http\JsonResponse;
use Illuminate\Support\Facades\Cache;
use Illuminate\Support\Facades\Validator;

trait HasDestroy
{
    use HasCache;
    use HasModel;

    public function destroy(mixed $id): JsonResponse
    {
        $validator = Validator::make(['id' => $id], [
            'id' => 'int',
        ]);

        if ($validator->fails()) {
            return response()->json(['error' => 'Invalid ID'], 400);
        }

        $cacheKey = $this->getEntityCacheKey($id);
        Cache::forget($cacheKey);

        $model = $this->model->findOrFail($id);
        $model->delete();

        return response()->json(null, 204);
    }

}
