<?php

namespace App\Http\Middleware;

use App\Http\Controllers\EmployeeController;
use App\Models\Employee;
use Closure;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class UserMiddleware
{
    /**
     * Handle an incoming request.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \Closure(\Illuminate\Http\Request): (\Illuminate\Http\Response|\Illuminate\Http\RedirectResponse)  $next
     * @return \Illuminate\Http\Response|\Illuminate\Http\RedirectResponse
     */
    public function handle(Request $request, Closure $next)
    {

        if (Auth::check()) {

            if (Auth::user()->role==0) {

                if (Auth::user()->employee->is_new == true && !$request->is('employee/'.Auth::user()->employee->id.'/edit')) {

                    return redirect('/employee/'.Auth::user()->employee->id.'/edit');

                } else {

                    return $next($request);
                }

            } else {

                return route('login');
            }

        }

        return $next($request);
    }
}
