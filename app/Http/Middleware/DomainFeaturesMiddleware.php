<?php

namespace App\Http\Middleware;

use Closure;

class DomainFeaturesMiddleware
{
    /**
     * Handle an incoming request.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \Closure  $next
     * @return mixed
     */
    public function handle($request, Closure $next, $feature)
    {
        $subdomain = app('router')->current()->getParameter('domain');

        // Get a list of features that are enabled for this domain
        $config = config("domains.subdomains.{$subdomain}.features", []);

        // If the feature that's being requested isn't enabled then issue a 404
        if (!in_array($feature, $config)) {
            abort(404);
        }

        return $next($request);
    }
}
