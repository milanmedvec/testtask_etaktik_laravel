<?php

namespace App\Http\Controllers\Api;

use App\Classes\ApiController\HasCreate;
use App\Classes\ApiController\HasDestroy;
use App\Classes\ApiController\HasIndex;
use App\Classes\ApiController\HasShow;
use App\Classes\ApiController\HasUpdate;
use App\Models\Post;
use Illuminate\Http\Request;

class PostApiController extends ApiController
{
    use HasIndex;
    use HasCreate {
        store as protected storePost;
    }
    use HasShow;
    use HasUpdate {
        update as protected updatePost;
    }
    use HasDestroy;

    public function __construct()
    {
        parent::__construct(new Post());
    }

    protected function validateStoreRequest(Request $request)
    {
        $request->validate([
            'author_id' => 'required|integer',
            'title' => 'required|string',
            'body' => 'required|string',
            'tags_ids' => 'array',
            'tags_ids.*' => 'integer',
        ]);
    }

    public function store(Request $request)
    {
        $model = $this->storePost($request);

        $tags = $request->input('tags_ids');
        if (is_array($tags)) {
            $model->tags()->sync($tags);
        }

        return $model;
    }

    protected function validateUpdateRequest(Request $request)
    {
        $request->validate([
            'author_id' => 'integer',
            'title' => 'string',
            'body' => 'string',
            'tags_ids' => 'array',
            'tags_ids.*' => 'integer',
        ]);
    }

    public function update(Request $request, $id)
    {
        $model = $this->updatePost($request, $id);

        $tags = $request->input('tags_ids');
        if (is_array($tags)) {
            $model->tags()->sync($tags);
        }

        return $model;
    }
}
