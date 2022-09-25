<?php

namespace App\Http\Middleware;
use App\Http\Traits\ApiResponseTrait;

use Closure;
use JWTAuth;
use Exception;
use Illuminate\Http\Request;
use Tymon\JWTAuth\Http\Middleware\BaseMiddleware;

class AuthToken extends BaseMiddleware
{
    use ApiResponseTrait;

    /** 
     * Handle an incoming request.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \Closure  $next
     * @return mixed
     */
    public function handle(Request $request, Closure $next)
    {
        try {
               $user = JWTAuth::parseToken()->authenticate();
           } catch (Exception $e) {
               if ($e instanceof \Tymon\JWTAuth\Exceptions\TokenInvalidException){
                   return $this->apiResponse(null , "token invalid" , 422 );

               }else if ($e instanceof \Tymon\JWTAuth\Exceptions\TokenExpiredException){
                   return $this->apiResponse(null , "Token is Expired" , 422 );
               }else{
                   return $this->apiResponse(null , "Authorization Token not found" , 422 );
               }
           }
           return $next($request);
    }
}
