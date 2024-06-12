<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;

class UserRoleCheck
{
    /**
     * Handle an incoming request.
     *
     * @param  \Closure(\Illuminate\Http\Request): (\Symfony\Component\HttpFoundation\Response)  $next
     */
    public function handle(Request $request, Closure $next, ...$permissions): Response
    {
        
        $arraytostring = implode($permissions);

        $decode = $request->user()->Role->permissions;
        $jsondecode = json_decode($decode, true);
        if (in_array('All', $jsondecode) == true) {
            return $next($request);
        }
        elseif (in_array($arraytostring, $jsondecode) == false) {
            abort(403, 'Unauthorized action.');
        }
        return $next($request);
    }
}
