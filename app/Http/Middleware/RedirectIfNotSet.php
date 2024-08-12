<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;
use Illuminate\Support\Facades\Log;

class RedirectIfNotSet
{
    /**
     * Handle an incoming request.
     *
     * @param  \Closure(\Illuminate\Http\Request): (\Symfony\Component\HttpFoundation\Response)  $next
     */
    public function handle(Request $request, Closure $next): Response
    {
        Log::info('test');
        if (auth()->user()->is_pres) {
            $so_list = auth()->user()->createdBySoLists;
            Log::info($so_list);
            // if ($so_list->count() == 0) {
            //     // Redirect president to student organization profile menu
            //     return redirect(route('admin.so-lists.create'));
            // } else
            // if (!auth()->user()->is_pres) {
            //     return redirect(route('admin.home'));
            // }
            // else

            if ($so_list->count() == 0) {
                // Redirect president to student organization profile menu
                // return redirect(route('admin.so-lists.create'));
            }
        }

        return $next($request);
    }
}
