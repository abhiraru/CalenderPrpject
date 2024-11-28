<?php

namespace App\Http\Middleware;

use App\Models\Configurations;
use Closure;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;

class CheckToken
{
    /**
     * Handle an incoming request.
     *
     * @param  \Closure(\Illuminate\Http\Request): (\Symfony\Component\HttpFoundation\Response)  $next
     */
    public function handle(Request $request, Closure $next): Response
    {
        $token = $request->header('Authorization');
        if (!$token) {
            return response()->json(['error' => 'Token is missing'], 401);
        }
        $user = Configurations::where('token', $token)->first();
        if (!$user) {
            return response()->json(['error' => 'Invalid token'], 401);
        }
        return $next($request);
    }
}
