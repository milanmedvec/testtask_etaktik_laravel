<?php

namespace App\Http\Controllers\Api;

use App\Classes\ApiController\HasDestroy;
use App\Classes\ApiController\HasIndex;
use App\Classes\ApiController\HasShow;
use App\Models\Tag;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Cache;

class TagApiController extends ApiController
{
    use HasIndex;
    use HasShow;
    use HasDestroy;

    public function __construct()
    {
        parent::__construct(new Tag());
    }


    public function store(Request $request)
    {
        $validated = $request->validate([
            // Name is required and must be a string
            'name' => 'required|string',
        ]);

        return Tag::create($validated);
    }

    public function update(Request $request, $id)
    {
        $validated = $request->validate([
            // Name must be a string
            'name' => 'string',
        ]);

        $cacheKey = $this->getEntityCacheKey($id);
        Cache::forget($cacheKey);

        $tag = Tag::findOrFail($id);
        $tag->update($validated);

        return $tag;
    }
}
