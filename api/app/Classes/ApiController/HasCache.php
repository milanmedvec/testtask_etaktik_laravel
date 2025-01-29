<?php

namespace App\Classes\ApiController;

trait HasCache
{
    use HasModel;

    private function getEntityCacheKey($id)
    {
        $modelName = $this->model->getModel()->getTable();
        return $modelName . '.' . $id;
    }

}
