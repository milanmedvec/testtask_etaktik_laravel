<?php

namespace App\Classes\ApiController;

trait HasCache
{
    use HasModel;

    protected function getEntityCacheKey($id)
    {
        $modelName = $this->model->getModel()->getTable();
        return $modelName . '.' . $id;
    }

}
