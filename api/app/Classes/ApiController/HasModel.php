<?php

namespace App\Http\Controllers\Api;

use Illuminate\Database\Eloquent\Model;

trait HasModel
{

    protected Model $model;

    public function __construct(Model $model)
    {
        $this->model = $model;
    }

}
