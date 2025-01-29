<?php

namespace App\Http\Controllers\Api;

use Illuminate\Support\Facades\Cache;

trait HasShow
{
    use HasModel;
    use HasCache;

    public function show($id)
    {
        $cacheKey = $this->getEntityCacheKey($id);
        $value = Cache::get($cacheKey);
        if ($value) {
            return $value;
        }

        $entity = $this->model->findOrFail($id);
        Cache::put($cacheKey, $entity, 60);
        return $entity;
    }

}
