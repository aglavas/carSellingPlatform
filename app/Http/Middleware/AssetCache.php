<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Response;

class AssetCache
{
    /**
     * Handle an incoming request.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \Closure  $next
     * @param  string|null  $guard
     * @return mixed
     */
    public function handle($request, Closure $next, $guard = null)
    {
        /** @var Response $response */
        $response = $next($request);

        $etag = md5($response->getContent());

        $options = [
            'etag' => $etag,
            'no_cache' => true,
            'max_age' => 2628000,
        ];

        $response->setCache($options);

        // Perform action
        return $response;
    }
}
