<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\Post;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;

class PostCommentApiController extends Controller
{

    public function index(Post $post): JsonResponse
    {
        $count = $post->comments()->count();
        $items = $post->comments()->get();

        return response()->json($items, 200, [
            'Content-Range' => $count,
        ]);
    }

    public function store(Request $request, Post $post): JsonResponse
    {
        $validated = $request->validate([
            // Body must be a string and is required
            'body' => 'required|string',
        ]);

        $comment = $post->comments()->create($validated);

        return response()->json($comment, 201);
    }

}
