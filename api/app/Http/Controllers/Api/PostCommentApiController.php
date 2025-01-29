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

    public function store(Request $request, Post $post)
    {
        $validated = $request->validate([
            // Body must be a string and is required
            'body' => 'required|string',
        ]);

        return $post->comments()->create($validated);
    }

}
