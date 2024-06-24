<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\View;

class SetPageTitle
{
    public function handle(Request $request, Closure $next)
    {
        View::share('pageTitle', config('app.name', 'K UI'));

        return $next($request);
    }
}

