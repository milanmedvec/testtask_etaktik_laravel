<?php

namespace App\Classes\ApiController;

use Illuminate\Database\Eloquent\Model;

trait HasModel
{

    protected Model $model;

    public function __construct(Model $model)
    {
        $this->model = $model;
    }

}
