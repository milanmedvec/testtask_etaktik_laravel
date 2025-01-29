<?php

namespace App\Http\Controllers\Api;

use App\Classes\ApiController\HasModel;
use App\Http\Controllers\Controller;
use Illuminate\Routing\Controllers\HasMiddleware;

abstract class ApiController extends Controller implements HasMiddleware
{
    use HasModel;

    public static function middleware()
    {
        return 'throttle:global';
    }

}
