<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;

class Cors
{
    /**
     * Handle an incoming request.
     *
     * @param  \Closure(\Illuminate\Http\Request): (\Symfony\Component\HttpFoundation\Response)  $next
     */
    public function handle(Request $request, Closure $next): Response
    {
        // Add headers for CORS
        return $next($request)
        ->header('Access-Control-Allow-Origin: *')
        ->header("Access-Control-Allow-Headers: X-API-KEY, Origin, X-Requested-With, Content-Type, Accept, Access-Control-Request-Method, Author")
        ->header("Access-Control-Allow-Methods: GET, POST, OPTIONS, PUT, DELETE")
        ->header("Allow: GET, POST, OPTIONS, PUT, DELETE");
    }
}
