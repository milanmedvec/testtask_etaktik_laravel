<?php

namespace App\Http\Controllers\Api;

use App\Models\Tag;

class TagApiController extends ApiController
{
    public function __construct()
    {
        parent::__construct(new Tag());
    }
}
