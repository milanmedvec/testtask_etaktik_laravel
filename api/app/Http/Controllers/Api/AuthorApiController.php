<?php

namespace App\Http\Controllers\Api;

use App\Classes\ApiController\HasCreate;
use App\Classes\ApiController\HasDestroy;
use App\Classes\ApiController\HasIndex;
use App\Classes\ApiController\HasShow;
use App\Classes\ApiController\HasUpdate;
use App\Models\Author;
use Illuminate\Http\Request;

class AuthorApiController extends ApiController
{
    use HasIndex;
    use HasCreate;
    use HasShow;
    use HasUpdate;
    use HasDestroy;

    public function __construct()
    {
        parent::__construct(new Author());
    }

    protected function validateStoreRequest(Request $request)
    {
        $request->validate([
            'first_name' => 'required|string',
            'last_name' => 'required|string',
        ]);
    }

    protected function validateUpdateRequest(Request $request)
    {
        $request->validate([
            'first_name' => 'string',
            'last_name' => 'string',
        ]);
    }
}
