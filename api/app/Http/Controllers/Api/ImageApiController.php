<?php

namespace App\Http\Controllers\Api;

use App\Models\Image;
use Illuminate\Http\Request;

class ImageApiController extends ApiController
{
    use HasIndex;
    use HasCreate {
        store as protected storeImage;
    }
    use HasShow;
    use HasUpdate {
        update as protected updateImage;
    }
    use HasDestroy;

    public function __construct()
    {
        parent::__construct(new Image());
    }

    protected function validateStoreRequest(Request $request)
    {
        $request->validate([
            'author_id' => 'required|integer',
            'title' => 'required|string',
            'url' => 'required|string',
            'tags_ids' => 'array',
            'tags_ids.*' => 'integer',
        ]);
    }

    public function store(Request $request)
    {
        $model = $this->storeImage($request);

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
            'url' => 'string',
            'tags_ids' => 'array',
            'tags_ids.*' => 'integer',
        ]);
    }

    public function update(Request $request, $id)
    {
        $model = $this->updateImage($request, $id);

        $tags = $request->input('tags_ids');
        if (is_array($tags)) {
            $model->tags()->sync($tags);
        }

        return $model;
    }

}
