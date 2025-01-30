<?php

namespace App\Classes\ApiController;

trait HasCache
{
    use HasModel;

    protected function getEntityCacheKey(int $id): string
    {
        $modelName = $this->model->getModel()->getTable();
        return $modelName . '.' . $id;
    }

}
