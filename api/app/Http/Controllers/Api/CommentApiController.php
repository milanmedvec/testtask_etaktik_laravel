<?php

namespace App\Http\Controllers\Api;

use App\Classes\ApiController\HasDestroy;
use App\Classes\ApiController\HasIndex;
use App\Classes\ApiController\HasShow;
use App\Classes\ApiController\HasUpdate;
use App\Models\Comment;
use Illuminate\Http\Request;

class CommentApiController extends ApiController
{
    use HasIndex;
    use HasShow;
    use HasUpdate;
    use HasDestroy;

    public function __construct()
    {
        parent::__construct(new Comment());
    }

    protected function validateUpdateRequest(Request $request)
    {
        $request->validate([
            'body' => 'string',
        ]);
    }
}
