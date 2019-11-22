<?php

namespace App\Http\Middleware;

use Closure;
use Exception;
use App\Models\User;
use Firebase\JWT\JWT;
use Firebase\JWT\ExpiredException;

class JwtMiddleware
{
    public function handle($request, Closure $next, $guard = null)
    {
        $token = $request->bearerToken();

        if (!$token) {
            return response()->json(['status' => 0, 'data' => [], 'errors' => 'Token not provided.'], 401);
        }

        try {
            $credentials = JWT::decode($token, env('JWT_SECRET'), ['HS256']);
        } catch(ExpiredException $e) {
            return response()->json(['status' => 0, 'data' => [], 'errors' => 'Provided token is expired.'], 400);
        } catch(Exception $e) {
            return response()->json(['status' => 0, 'data' => [], 'errors' => 'An error while decoding token.', 
            'message' => $e->getMessage()], 400);
        }

        $user = User::find($credentials->sub);

        $request->auth = $user;

        return $next($request);
    }
}