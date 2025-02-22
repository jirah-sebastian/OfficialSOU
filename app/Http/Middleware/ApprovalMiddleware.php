<?php

namespace App\Http\Middleware;

use App\Models\Role;
use Closure;
use Illuminate\Support\Facades\Gate;

class ApprovalMiddleware
{
    public function handle($request, Closure $next)
    {
        if (auth()->check()) {
            if (auth()->user()->approved == 'Pending') {
                auth()->logout();

                return redirect()->route('login')->with('message', trans('global.yourAccountNeedsAdminApproval'));
            }
            elseif(auth()->user()->approved == 'Rejected'){
                return redirect()->route('login')->with('message', 'Your account has been Rejected');
            }

        }

        return $next($request);
    }
}