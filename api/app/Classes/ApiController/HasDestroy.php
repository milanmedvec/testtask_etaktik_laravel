<?php

namespace App\Http\Controllers\Api;

use Illuminate\Support\Facades\Cache;

trait HasDestroy
{
    use HasCache;
    use HasModel;

    public function destroy($id)
    {
        $cacheKey = $this->getEntityCacheKey($id);
        Cache::forget($cacheKey);

        $model = $this->model->findOrFail($id);
        $model->delete();
        return $model;
    }

}
