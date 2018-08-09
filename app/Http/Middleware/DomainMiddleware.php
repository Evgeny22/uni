<?php

namespace App\Http\Middleware;

use Closure;
use Config;
use DB;

class DomainMiddleware
{
    /**
     * Handle an incoming request.
     *
     * @param  Illuminate\Http\Request  $request
     * @param  Closure  $next
     * @param  string   $domain
     * @return mixed
     */
    public function handle($request, Closure $next)
    {
        $subdomain = app('router')->current()->getParameter('domain');

        // Swap out the database to match the domain
        //DB::setDefaultConnection($subdomain);

        // Reconnect to the DB using the new details
        //DB::reconnect();

        return $next($request);
    }
}
