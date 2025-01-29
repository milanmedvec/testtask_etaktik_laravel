<?php

namespace App\Http\Controllers\Api;

trait HasCache
{
    use HasModel;

    private function getEntityCacheKey($id)
    {
        $modelName = $this->model->getModel()->getTable();
        return $modelName . '.' . $id;
    }

}
