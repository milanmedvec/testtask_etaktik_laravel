<?php

namespace App\Classes\ApiController;

use Illuminate\Http\Request;

trait HasCreate
{
    use HasModel;

    protected function validateStoreRequest(Request $request) {}

    public function store(Request $request)
    {
        $validated = $this->validateStoreRequest($request);
        return $this->model->create($validated);
    }

}
