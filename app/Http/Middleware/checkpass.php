<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;

class checkpass
{
    /**
     * Handle an incoming request.
     *
     * @param  \Closure(\Illuminate\Http\Request): (\Symfony\Component\HttpFoundation\Response)  $next
     */
    public function handle(Request $request, Closure $next): Response
    {
        if($request->api_password != env("API_PASSWORD","lcProyfFcIuBVcGx20WwdTOThAXW19usLPMDfJZGrRB9p4ii78L88")){
            return response()->json(['message'=> 'unauthnticated']);
        }
        return $next($request);
    }
}
