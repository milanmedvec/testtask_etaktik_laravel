<?php

use Illuminate\Support\Facades\Route;

Route::apiResource('authors', '\App\Http\Controllers\Api\AuthorApiController');

Route::apiResource('tags', '\App\Http\Controllers\Api\TagApiController');
Route::apiResource('comments', '\App\Http\Controllers\Api\CommentApiController');

Route::apiResource('images', '\App\Http\Controllers\Api\ImageApiController');

Route::apiResource('posts', '\App\Http\Controllers\Api\PostApiController');

Route::get('/', function () {
    return response()->json(['message' => 'API', 'status' => 'Connected']);
});
