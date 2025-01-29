<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

abstract class ApiController extends Controller
{
    protected $model;

    public function __construct($model)
    {
        $this->model = $model;
    }

    public function index()
    {
        $count = $this->model->count();
        $items = $this->model->all();

        return response()->json($items, 200, [
            'Content-Range' => $count,
        ]);
    }

    public function show($id)
    {
        return $this->model->findOrFail($id);
    }

    public function store(Request $request)
    {
        return $this->model->create($request->all());
    }

    public function update(Request $request, $id)
    {
        $model = $this->model->findOrFail($id);
        $model->update($request->all());
        return $model;
    }

    public function destroy($id)
    {
        $model = $this->model->findOrFail($id);
        $model->delete();
        return $model;
    }
}
