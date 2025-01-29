<?php

namespace App\Http\Controllers\Api;

use App\Models\Tag;
use Illuminate\Http\Request;

class TagApiController extends ApiController
{
    use HasIndex;
    use HasCreate;
    use HasShow;
    use HasUpdate;
    use HasDestroy;

    public function __construct()
    {
        parent::__construct(new Tag());
    }

    protected function validateStoreRequest(Request $request)
    {
        $request->validate([
            'name' => 'required|string',
        ]);
    }

    protected function validateUpdateRequest(Request $request)
    {
        $request->validate([
            'name' => 'string',
        ]);
    }
}
