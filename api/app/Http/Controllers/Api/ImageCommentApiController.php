<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\Image;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;

class ImageCommentApiController extends Controller
{

    public function index(Image $image): JsonResponse
    {
        $count = $image->comments()->count();
        $items = $image->comments()->get();

        return response()->json($items, 200, [
            'Content-Range' => $count,
        ]);
    }

    public function store(Request $request, Image $image): JsonResponse
    {
        $validated = $request->validate([
            // Body must be a string and is required
            'body' => 'required|string',
        ]);

        $comment = $image->comments()->create($validated);

        return response()->json($comment, 201);
    }

}
