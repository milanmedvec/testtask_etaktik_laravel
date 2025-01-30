<?php

namespace App\Classes\ApiController;

use Illuminate\Http\JsonResponse;
use Illuminate\Support\Facades\Cache;
use Illuminate\Support\Facades\Validator;

trait HasShow
{
    use HasModel;
    use HasCache;

    public function show(mixed $id): JsonResponse
    {
        $validator = Validator::make(['id' => $id], [
            'id' => 'int',
        ]);

        if ($validator->fails()) {
            return response()->json(['error' => 'Invalid ID'], 400);
        }

        $cacheKey = $this->getEntityCacheKey($id);
        $value = Cache::get($cacheKey);
        if ($value) {
            return $value;
        }

        $entity = $this->model->findOrFail($id);
        Cache::put($cacheKey, $entity, 60);

        return response()->json($entity);
    }

}
