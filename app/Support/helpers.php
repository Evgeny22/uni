<?php

if (! function_exists('route')) {
    /**
     * Generate a URL to a named route.
     *
     * @param  string  $name
     * @param  array   $parameters
     * @param  bool    $absolute
     * @param  \Illuminate\Routing\Route  $route
     * @return string
     */
    function route($name, $parameters = [], $absolute = true, $route = null)
    {
        try {
            $parameters['domain'] = app('router')->current()->getParameter('domain');
        } catch (\Exception $e) {

        }

        return app('url')->route($name, $parameters, $absolute, $route);
    }
}

/**
 * Generate a URL to a named route.
 *
 * @param  string  $name
 * @param  array   $parameters
 * @param  bool    $absolute
 * @param  \Illuminate\Routing\Route  $route
 * @return string
 */
function _route($name, $parameters = [], $absolute = true, $route = null)
{
    try {
        $parameters['domain'] = app('router')->current()->getParameter('domain');
    } catch (\Exception $e) {

    }

    return app('url')->route($name, $parameters, $absolute, $route);
}

function secondsToTime($seconds) {
    $minutes = floor(($seconds / 60));
    $s = $seconds % 60;

    if ($s < 10) {

        $s = "0" . $s;

    }

    // Round seconds
    $s = round($s);

    return ['m' => $minutes, 's' => $s];
}

function joinWithAnd($array) {
    if (count($array)) {
        echo join(' and ', array_filter(array_merge(array(join(', ', array_slice($array, 0, -1))), array_slice($array, -1)), 'strlen'));
    }
}