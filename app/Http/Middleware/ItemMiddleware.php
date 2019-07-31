<?php

namespace App\Http\Middleware;

use Closure;

class ItemMiddleware
{
    /**
     * Handle an incoming request.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \Closure  $next
     * @return mixed
     */
    public function handle($request, Closure $next)
    {
        if (
            $request->route('pageNum') === null
            || intval($request->route('pageNum')) === 0
            || intval($request->route('pageNum')) < 0
        ) {
            return redirect('api/items/1');
        }
        return $next($request);
    }
}
