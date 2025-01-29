<?php

namespace App\Http\Controllers\Api;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Cache;

trait HasUpdate
{
    use HasModel;
    use HasCache;

    protected function validateUpdateRequest(Request $request) {}

    public function update(Request $request, $id)
    {
        $cacheKey = $this->getEntityCacheKey($id);
        Cache::forget($cacheKey);

        $validated = $this->validateUpdateRequest($request);

        $model = $this->model->findOrFail($id);
        $model->update($validated);
        return $model;
    }

}
