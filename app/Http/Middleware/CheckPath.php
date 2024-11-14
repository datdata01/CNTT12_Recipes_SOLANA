<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;

class CheckPath
{
    public function handle(Request $request, Closure $next)
    {
        $excludedPaths = [
            'order-success/',  // duong dan loai tru check
        ];

        // Extract the path from the request
        $currentPath = $request->path(); // This will get 'order-success/'
        if (
            $request->is('admin/*') &&
            !in_array($currentPath, $excludedPaths) &&
            !preg_match('/^[a-zA-Z0-9_\-\/]+$/', $currentPath)
        ) {
            return response()->view('errors.404', [], 404);
        }
        return $next($request);
    }
}
