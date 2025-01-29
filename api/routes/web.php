<?php

use Illuminate\Support\Facades\Route;

function generateCommentsResourceRoutes($controllerName, $resourceName)
{
    $controllerName = "\\App\\Http\\Controllers\\Api\\" . $controllerName;

    Route::prefix($resourceName)->group(function() use($controllerName) {
        Route::get("/", $controllerName . "@index");
        Route::post("/", $controllerName . "@store");
    });
}

Route::apiResource('authors', '\App\Http\Controllers\Api\AuthorApiController');

Route::apiResource('tags', '\App\Http\Controllers\Api\TagApiController');
Route::apiResource('comments', '\App\Http\Controllers\Api\CommentApiController', ["except" => ["store"]]);

Route::apiResource('images', '\App\Http\Controllers\Api\ImageApiController');
generateCommentsResourceRoutes('ImageCommentApiController', 'images/{image}/comments');

Route::apiResource('posts', '\App\Http\Controllers\Api\PostApiController');
generateCommentsResourceRoutes('PostCommentApiController', 'posts/{post}/comments');

// TODO(milan.medvec) 404 route
// TODO(milan.medvec) open api route

Route::get('/', function () {
    return response()->json(['message' => 'API', 'status' => 'Connected']);
});
