<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Foundation\Http\Middleware\VerifyCsrfToken as Middleware;

class VerifyCsrfToken extends Middleware
{
    /**
     * The URIs that should be excluded from CSRF verification.
     *
     * @var array<int, string>
     */
    protected $except = [
        //
    ];
    public function handle($request, Closure $next)
{
    $response = $next($request);

    // Thêm các tiêu đề CORS vào phản hồi
    $response->headers->set('Access-Control-Allow-Origin', 'http://localhost:5173');
    $response->headers->set('Access-Control-Allow-Methods', 'GET, POST, PUT, DELETE');
    $response->headers->set('Access-Control-Allow-Headers', 'Content-Type, Authorization');

    return $response;
}
}
