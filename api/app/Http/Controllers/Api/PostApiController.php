<?php

namespace App\Http\Controllers\Api;

use App\Models\Post;
use Illuminate\Http\Request;

class PostApiController extends ApiController
{
    public function __construct()
    {
        parent::__construct(new Post());
    }

    public function store(Request $request)
    {
        $model = parent::store($request);

        $tags = $request->input('tags_ids');
        if (is_array($tags)) {
            $model->tags()->sync($tags);
        }

        return $model;
    }

    public function update(Request $request, $id)
    {
        $model = parent::update($request, $id);

        $tags = $request->input('tags_ids');
        if (is_array($tags)) {
            $model->tags()->sync($tags);
        }

        return $model;
    }
}
