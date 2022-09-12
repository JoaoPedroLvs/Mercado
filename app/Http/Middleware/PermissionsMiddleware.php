<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Session;

class PermissionsMiddleware
{
    /**
     * Handle an incoming request.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \Closure(\Illuminate\Http\Request): (\Illuminate\Http\Response|\Illuminate\Http\RedirectResponse)  $next
     * @return \Illuminate\Http\Response|\Illuminate\Http\RedirectResponse
     */
    public function handle(Request $request, Closure $next, $role, $permission = null)
    {

        $user = Auth::user();

        if ($role == 'customer') {


            if (isset($user->customer_id) || isset($user->manager_id) && $permission != 'only') {

                // dd(isset($user->manager_id));
                if (isset($user->manager_id)) {
                    $data = [
                        'customer' => true,
                        'manager' => true,
                        'employee' => false
                    ];

                } else {

                    $data = [
                        'customer' => true,
                        'manager' => false,
                        'employee' => false
                    ];
                }

                if ($user->customer->is_new && !$request->is('customer/'.$user->customer->id.'/edit')) {
                    return redirect('customer/'.$user->customer->id.'/edit');
                }

                $request->session()->put($data);

                return $next($request);

            } else {

                if (!isset($user->manager_id) && isset($user->customer_id)) {

                    if (isset($user->manager_id)) {

                        $data = [
                            'customer' => true,
                            'manager' => true,
                            'employee' => false
                        ];

                    } else {

                        $data = [
                            'customer' => true,
                            'manager' => false,
                            'employee' => false
                        ];
                    }


                    $request->session()->put($data);
                    return $next($request);

                } else {

                    return back()->with(Session::flash('error', 'Não possui permissão para acessar essa página'));
                }
            }

        }

        if ($role == 'employees') {

            if (isset($user->employee_id) || isset($user->manager_id) && $permission != 'only') {

                if (isset($user->manager_id)) {

                    $data = [
                        'customer' => false,
                        'employee' => true,
                        'manager' => true
                    ];

                } else {

                    $data = [
                        'customer' => false,
                        'manager' => false,
                        'employee' => true
                    ];
                }

                $request->session()->put($data);

                return $next($request);

            } else {

                if (!isset($user->manager_id) && isset($user->employee_id)) {

                    $data = [
                        'customer' => false,
                        'employee' => true,
                        'manager' => false
                    ];
                    $request->session()->put($data);

                    return $next($request);

                } else {

                    return back()->with(Session::flash('error', 'Não possui permissão para acessar essa página'));
                    // throw new \Exception('Não possui permissão para acessar essa página');
                }
            }

        }

        if ($role == 'manager') {

            if (isset($user->manager_id)) {

                $data = [
                    'customer' => false,
                    'employee' => false,
                    'manager' => true
                ];
                $request->session()->put($data);

                return $next($request);

            } else {

                return back()->with(Session::flash('error', 'Não possui permissão para acessar essa pagina'));

            }

        } else {

            return back()->with(Session::flash('error', 'Não possui permissão para acessar essa pagina'));
        }
    }
}
