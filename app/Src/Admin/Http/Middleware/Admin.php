<?php

namespace App\Src\Admin\Http\Middleware;

use Closure;

class Admin
{
    public function handle($request, Closure $next)
    {
        if (true) {
            return $next($request);
        }
        abort(403);
    }
}
