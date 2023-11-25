<?php

namespace App\Http\Middleware;

use Cache;
use Closure;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Http;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\HttpFoundation\Response as ResponseAlias;

class AuthUser {
    /**
     * Handle an incoming request.
     *
     * @param \Closure(\Illuminate\Http\Request): (\Symfony\Component\HttpFoundation\Response) $next
     */
    public function handle(Request $request, Closure $next): Response
    {
        // Get the token from the query string
        $token = $request->header('Authorization');

        // If token is not present, return unauthorized response
        if (!$token) {
            return response()->json([
                'status' => false,
                'message' => 'Unauthorized'
            ], status: ResponseAlias::HTTP_UNAUTHORIZED);
        }

        // Call the AuthService to get user information based on the token
        $response = Http::withHeaders([
            'Authorization' => 'Bearer ' . $token,
            'Accept' => 'application/json',
            'Content-Type' => 'application/json'
        ])->get('http://127.0.0.1:8001/api/v1/me');


        // Check if the response
        // was successful
        if ($response->successful()) {
            // Get user data from the response
            $user = $response->json('data');

            // Set the user manually in Laravel's Auth
            Cache::put('user_id', $user['id']);
            // Continue with the request
            return $next($request);
        }
        // If AuthService returns an error, return unauthorized response
        return response()->json([
            'status' => false,
            'message' => 'Unauthorized'
        ], status: ResponseAlias::HTTP_UNAUTHORIZED);
    }
}
