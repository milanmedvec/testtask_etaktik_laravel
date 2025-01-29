<?php

namespace App\Http\Controllers\Api;

use App\Models\Author;

class AuthorApiController extends ApiController
{
    public function __construct()
    {
        parent::__construct(new Author());
    }
}
