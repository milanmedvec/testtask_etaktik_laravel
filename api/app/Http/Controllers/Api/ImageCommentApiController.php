<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\Comment;
use App\Models\Image;
use Illuminate\Http\Request;

class ImageCommentApiController extends Controller
{

    public function index(Image $image)
    {
        $count = $image->comments()->count();
        $items = $image->comments()->get();

        return response()->json($items, 200, [
            'Content-Range' => $count,
        ]);
    }

    protected function validateStoreRequest(Request $request)
    {
        $request->validate([
            'content' => 'required|string',
        ]);
    }

    public function store(Request $request, Image $image)
    {
        $comment = new Comment($request->all());
        $comment->image()->associate($image);
        $comment->save();
        return $comment;
    }

}
