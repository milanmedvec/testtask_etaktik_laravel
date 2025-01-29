<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\Comment;
use App\Models\Post;
use Illuminate\Http\Request;

class PostCommentApiController extends Controller
{

    public function index(Post $post)
    {
        $count = $post->comments()->count();
        $items = $post->comments()->get();

        return response()->json($items, 200, [
            'Content-Range' => $count,
        ]);
    }

    protected function validateStoreRequest(Request $request)
    {
        $request->validate([
            // Content must be a string and is required
            'content' => 'required|string',
        ]);
    }

    public function store(Request $request, Post $post)
    {
        $comment = new Comment($request->all());
        $comment->image()->associate($post);
        $comment->save();
        return $comment;
    }

}
