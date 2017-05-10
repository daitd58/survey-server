<?php

namespace App\Http\Middleware;

use Closure;
use App\User;
use Illuminate\Support\Facades\Auth;
use JWTAuth;

class Admin {
	/**
	 * Handle an incoming request.
	 *
	 * @param  \Illuminate\Http\Request $request
	 * @param  \Closure $next
	 *
	 * @return mixed
	 */
	public function handle( $request, Closure $next ) {
		try {
			if ( ! $user = JWTAuth::parseToken()->authenticate() ) {
				return response()->json( [ 'user_not_found' ], 404 );
			}

		} catch ( \Tymon\JWTAuth\Exceptions\TokenExpiredException $e ) {
			return response()->json( [ 'code' => $e->getStatusCode(), 'status' => 'token_invalid', 'data' => ['message' => 'Token invalid'] ], $e->getStatusCode() );
		} catch ( \Tymon\JWTAuth\Exceptions\TokenInvalidException $e ) {
			return response()->json( [ 'code' => $e->getStatusCode(), 'status' => 'token_invalid', 'data' => ['message' => 'Token invalid'] ], $e->getStatusCode() );
		} catch ( \Tymon\JWTAuth\Exceptions\JWTException $e ) {
			return response()->json( [ 'code' => $e->getStatusCode(), 'status' => 'token_invalid', 'data' => ['message' => 'Token invalid'] ], $e->getStatusCode() );
		}

		if ( $request->user()->role == 1 ) {
			return $next( $request );
		} else {
			return response()->json( [ 'user_not_admin' ], 400 );
		}
	}
}
