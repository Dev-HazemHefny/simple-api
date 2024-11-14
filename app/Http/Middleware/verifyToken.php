<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;
use Tymon\JWTAuth\Exceptions\TokenExpiredException;
use Tymon\JWTAuth\Exceptions\TokenInvalidException;
use Tymon\JWTAuth\Facades\JWTAuth;

class verifyToken
{
    /**
     * Handle an incoming request.
     *
     * @param  \Closure(\Illuminate\Http\Request): (\Symfony\Component\HttpFoundation\Response)  $next
     */
    public function handle(Request $request, Closure $next): Response
    {
        try{
            $token =$request->token;
            if($token){
                $user = JWTAuth::parseToken()->authenticate();
            }
        }catch(\Exception $e){
            if($e instanceof TokenInvalidException){
                return response()->json(['message'=>'token invalid']);
            }elseif($e instanceof TokenExpiredException){
                return response()->json(['message'=>'token expired']);
            }else{
                return response()->json(['message'=>'another exception']);                
            }
        }
        return $next($request);
    }
}
